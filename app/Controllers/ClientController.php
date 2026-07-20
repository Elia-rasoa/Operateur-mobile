<?php

namespace App\Controllers;

use App\Models\client\ClientModel;

class ClientController extends BaseController
{
    public function index()
    {
        $session = session();
        
        // Sécurité : Si le client n'est pas connecté, retour au login
        if (!$session->has('client_id')) {
            return redirect()->to('/')->with('error', 'Veuillez vous connecter pour accéder au tableau de bord.');
        }

        // Récupération des données fraîches du client (surtout le solde)
        $clientModel = new ClientModel();
        $clientData = $clientModel->find($session->get('client_id'));

        // Si par hasard le client n'existe plus en base, on détruit la session
        if (!$clientData) {
            $session->destroy();
            return redirect()->to('/')->with('error', 'Compte introuvable.');
        }

        // Préparation des données pour la vue
        $data = [
            'client' => $clientData
        ];

        return view('client/dashboard', $data);
    }

    public function depot()
    {
        $session = session();
        $clientId = $session->get('client_id');
        $montant = floatval($this->request->getPost('montant'));

        if ($montant < 100) {
            return redirect()->back()->with('error', 'Le montant minimum pour un dépôt est de 100 Ar.');
        }

        $clientModel = new ClientModel();
        
        // On récupère le solde actuel et on l'incrémente
        $client = $clientModel->find($clientId);
        $nouveauSolde = $client['solde'] + $montant;

        $clientModel->update($clientId, ['solde' => $nouveauSolde]);

        return redirect()->to('/client/dashboard')->with('success', 'Dépôt de ' . number_format($montant, 2, ',', ' ') . ' Ar effectué avec succès !');
    }
    /**
     * GESTION DES RETRAITS (Avec Frais)
     */
    public function retrait()
    {
        $session = session();
        $clientId = $session->get('client_id');
        $montant = floatval($this->request->getPost('montant'));

        if ($montant < 100) {
            return redirect()->back()->with('error', 'Le montant minimum pour un retrait est de 100 Ar.');
        }

        $clientModel = new ClientModel();
        $client = $clientModel->find($clientId);

        // --- CALCUL DES FRAIS DE RETRAIT ---
        // Option B (Simulation) : Exemple de 2% pour le retrait en attendant la table finale
        $frais = $montant * 0.02; 
        $totalA_Deduire = $montant + $frais;

        // Vérification si le solde couvre le montant demandé + les frais de retrait
        if ($client['solde'] < $totalA_Deduire) {
            return redirect()->back()->with('error', 'Solde insuffisant. Le retrait de ' . number_format($montant, 2, ',', ' ') . ' Ar nécessite ' . number_format($frais, 2, ',', ' ') . ' Ar de frais (Total: ' . number_format($totalA_Deduire, 2, ',', ' ') . ' Ar).');
        }

        $nouveauSolde = $client['solde'] - $totalA_Deduire;
        $clientModel->update($clientId, ['solde' => $nouveauSolde]);

        // Optionnel : Ici, tu pourras enregistrer $frais dans la table des gains opérateur de ton binôme

        return redirect()->to('/client/dashboard')->with('success', 'Retrait effectué. Montant : ' . number_format($montant, 2, ',', ' ') . ' Ar (Frais : ' . number_format($frais, 2, ',', ' ') . ' Ar).');
    }

    /**
     * GESTION DES TRANSFERTS (Avec Frais)
     */
    public function transfert()
    {
        $session = session();
        $clientId = $session->get('client_id');
        $telephoneDestinataire = $this->request->getPost('telephone_destinataire');
        $montant = floatval($this->request->getPost('montant'));

        if ($montant < 100) {
            return redirect()->back()->with('error', 'Le montant minimum pour un transfert est de 100 Ar.');
        }

        $clientModel = new ClientModel();
        $expediteur = $clientModel->find($clientId);

        if ($expediteur['numero_telephone'] === $telephoneDestinataire) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas effectuer un transfert vers votre propre numéro.');
        }

        $destinataire = $clientModel->where('numero_telephone', $telephoneDestinataire)->first();
        if (!$destinataire) {
            return redirect()->back()->with('error', 'Le numéro du destinataire n\'existe pas.');
        }

        // --- CALCUL DES FRAIS DE TRANSFERT ---
        // Option B (Simulation) : Exemple de 1% pour le transfert
        $frais = $montant * 0.01; 
        $totalA_Deduire = $montant + $frais;

        if ($expediteur['solde'] < $totalA_Deduire) {
            return redirect()->back()->with('error', 'Solde insuffisant. Il vous faut au moins ' . number_format($totalA_Deduire, 2, ',', ' ') . ' Ar (dont ' . number_format($frais, 2, ',', ' ') . ' Ar de frais).');
        }

        // Débit de l'expéditeur (Montant + Frais)
        $clientModel->update($expediteur['id'], ['solde' => $expediteur['solde'] - $totalA_Deduire]);
        
        // Crédit du destinataire (Uniquement le montant net initial)
        $clientModel->update($destinataire['id'], ['solde' => $destinataire['solde'] + $montant]);

        // Optionnel : Enregistrement des gains ici pour ton binôme

        return redirect()->to('/client/dashboard')->with('success', 'Transfert envoyé à ' . $telephoneDestinataire . '. Montant : ' . number_format($montant, 2, ',', ' ') . ' Ar (Frais : ' . number_format($frais, 2, ',', ' ') . ' Ar).');
    }
}
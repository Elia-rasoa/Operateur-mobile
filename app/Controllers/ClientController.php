<?php

namespace App\Controllers;

use App\Models\BaremeModel;
use App\Models\TransactionModel;
use App\Models\client\ClientModel;
use App\Models\client\TransactionModel;

class ClientController extends BaseController
{
    public function index()
    {
        $session = session();

        if (!$session->has('client_id')) {
            return redirect()->to('/')->with('error', 'Veuillez vous connecter pour accéder au tableau de bord.');
        }

        $clientModel = new ClientModel();
        $clientData = $clientModel->find($session->get('client_id'));

        if (!$clientData) {
            $session->destroy();
            return redirect()->to('/')->with('error', 'Compte introuvable.');
        }

        $transactionModel = new TransactionModel();
        $data = [
            'client' => $clientData,
            'transactions' => $transactionModel->getTransactionsByClient($session->get('client_id')),
        ];

        return view('client/dashboard', $data);
    }

    public function historique()
    {
        $session = session();

        if (!$session->has('client_id')) {
            return redirect()->to('/')->with('error', 'Veuillez vous connecter pour consulter votre historique.');
        }

        $clientModel = new ClientModel();
        $clientData = $clientModel->find($session->get('client_id'));

        if (!$clientData) {
            $session->destroy();
            return redirect()->to('/')->with('error', 'Compte introuvable.');
        }

        $transactionModel = new TransactionModel();
        $data = [
            'client' => $clientData,
            'transactions' => $transactionModel->getTransactionsByClient($session->get('client_id')),
        ];

        return view('client/historique', $data);
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
        $client = $clientModel->find($clientId);
        $nouveauSolde = $client['solde'] + $montant;

        $clientModel->update($clientId, ['solde' => $nouveauSolde]);
        $this->saveTransaction($clientId, 'depot', $montant, 0.0);

        // Enregistrement de la transaction
        $transactionModel = new TransactionModel();
        $transactionModel->insert([
            'client_source_id'      => $clientId,
            'client_destination_id' => null,
            'type_op_id'            => 1, // depot
            'montant'               => $montant,
            'frais_appliques'       => 0,
        ]);

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

        try {
            $tarification = $this->getTarification('retrait', $montant);
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        $frais = $tarification['frais'];
        $totalA_Deduire = $montant + $frais;

        if ($client['solde'] < $totalA_Deduire) {
            return redirect()->back()->with('error', 'Solde insuffisant. Le retrait de ' . number_format($montant, 2, ',', ' ') . ' Ar nécessite ' . number_format($frais, 2, ',', ' ') . ' Ar de frais (Total: ' . number_format($totalA_Deduire, 2, ',', ' ') . ' Ar).');
        }

        $nouveauSolde = $client['solde'] - $totalA_Deduire;
        $clientModel->update($clientId, ['solde' => $nouveauSolde]);
        $this->saveTransaction($clientId, 'retrait', $montant, $frais);

        // Enregistrement de la transaction
        $transactionModel = new TransactionModel();
        $transactionModel->insert([
            'client_source_id'      => $clientId,
            'client_destination_id' => null,
            'type_op_id'            => 2, // retrait
            'montant'               => $montant,
            'frais_appliques'       => $frais,
        ]);

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

        if (($expediteur['numero_telephone'] ?? $expediteur['telephone'] ?? '') === $telephoneDestinataire) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas effectuer un transfert vers votre propre numéro.');
        }

        $prefixModel = new PrefixModel();
        if (!$prefixModel->isPrefixAllowed($telephoneDestinataire)) {
            return redirect()->back()->with('error', 'Le numéro du destinataire n\'est pas couvert par un préfixe autorisé.');
        }

        $destinataire = $clientModel->findByTelephone($telephoneDestinataire);
        if (!$destinataire) {
            $destinataire = $clientModel->getOrCreateByTelephone($telephoneDestinataire);
        }

        try {
            $tarification = $this->getTarification('transfert', $montant);
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        $frais = $tarification['frais'];
        $totalA_Deduire = $montant + $frais;

        if ($expediteur['solde'] < $totalA_Deduire) {
            return redirect()->back()->with('error', 'Solde insuffisant. Il vous faut au moins ' . number_format($totalA_Deduire, 2, ',', ' ') . ' Ar (dont ' . number_format($frais, 2, ',', ' ') . ' Ar de frais).');
        }

        $clientModel->update($expediteur['id'], ['solde' => $expediteur['solde'] - $totalA_Deduire]);
        $clientModel->update($destinataire['id'], ['solde' => $destinataire['solde'] + $montant]);
        $this->saveTransaction($expediteur['id'], 'transfert', $montant, $frais, $destinataire['id']);

        // Enregistrement de la transaction
        $transactionModel = new TransactionModel();
        $transactionModel->insert([
            'client_source_id'      => $expediteur['id'],
            'client_destination_id' => $destinataire['id'],
            'type_op_id'            => 3, // transfert
            'montant'               => $montant,
            'frais_appliques'       => $frais,
        ]);

        $transactionModel = new TransactionModel();
        $transactionModel->insert([
            'type_op_id' => $typeOpId,
            'client_source_id' => $clientId,
            'client_destination_id' => $destinationClientId,
            'montant' => $montant,
            'frais_appliques' => $frais,
        ]);
    }
}
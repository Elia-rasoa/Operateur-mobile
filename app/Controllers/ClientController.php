<?php

namespace App\Controllers;

use App\Models\BaremeModel;
use App\Models\TransactionModel;
use App\Models\client\ClientModel;
use App\Models\client\PrefixModel;

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

        return redirect()->to('/client/dashboard')->with('success', 'Dépôt de ' . number_format($montant, 2, ',', ' ') . ' Ar effectué avec succès !');
    }

    /**
     * GESTION DES RETRAITS
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
            $tarificationRetrait = $this->getTarification('retrait', $montant);
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        
        $fraisRetraitTheoriques = $tarificationRetrait['frais'];

        $transactionModel = new TransactionModel();
        $baremeModel = new BaremeModel();
        $typeOpTransfert = $baremeModel->getTypeOperationId('transfert');

        // Correction critique : On cherche le dernier transfert reçu pour ce montant EXACT
        // ET qui possède notre marqueur spécial de gratuité (99999)
        $transfertRecu = $transactionModel->where('client_destination_id', $clientId)
                                          ->where('type_op_id', $typeOpTransfert)
                                          ->where('montant', $montant)
                                          ->where('frais_appliques', 99999)
                                          ->orderBy('id', 'DESC')
                                          ->first();

        $resultatFrais = $this->resolveRetraitFees($fraisRetraitTheoriques, $transfertRecu);
        $fraisAppliques = $resultatFrais['frais_appliques'];
        $dejaPayeParExpediteur = $resultatFrais['deja_paye_par_expediteur'];

        $totalA_Deduire = $montant + $fraisAppliques;

        if ($client['solde'] < $totalA_Deduire) {
            return redirect()->back()->with('error', 'Solde insuffisant. Requis : ' . number_format($totalA_Deduire, 2, ',', ' ') . ' Ar.');
        }

        $nouveauSolde = $client['solde'] - $totalA_Deduire;
        $clientModel->update($clientId, ['solde' => $nouveauSolde]);
        
        $this->saveTransaction($clientId, 'retrait', $montant, $fraisAppliques);

        if ($dejaPayeParExpediteur) {
            // On consomme le marqueur pour ne pas pouvoir réutiliser le retrait gratuit
            $transactionModel->update($transfertRecu['id'], ['frais_appliques' => 0]);

            return redirect()->to('/client/dashboard#nav-retrait')->with('success', 'Retrait effectué. Montant : ' . number_format($montant, 2, ',', ' ') . ' Ar. (Frais : 0 Ar - Offerts par l\'expéditeur !)');
        }

        return redirect()->to('/client/dashboard#nav-retrait')->with('success', 'Retrait effectué. Montant : ' . number_format($montant, 2, ',', ' ') . ' Ar (Frais : ' . number_format($fraisAppliques, 2, ',', ' ') . ' Ar).');
    }

    /**
     * GESTION DES TRANSFERTS
     */
    public function transfert()
    {
        $session = session();
        $clientId = $session->get('client_id');
        
        $chaineDestinataires = $this->request->getPost('telephone_destinataire');
        $montantSaisi = floatval($this->request->getPost('montant'));
        $inclureFraisRetrait = in_array($this->request->getPost('inclure_frais_retrait'), ['1', 'on', 'true'], true);

        if ($montantSaisi < 100) {
            return redirect()->back()->with('error', 'Le montant minimum pour une transaction est de 100 Ar.');
        }

        $clientModel = new ClientModel();
        $expediteur = $clientModel->find($clientId);
        $telephoneExpediteur = $expediteur['numero_telephone'] ?? $expediteur['telephone'] ?? '';

        $numerosTableau = explode(',', $chaineDestinataires);
        $destinatairesNumeros = array_filter(array_map('trim', $numerosTableau));
        $nombreDestinataires = count($destinatairesNumeros);

        if ($nombreDestinataires === 0) {
            return redirect()->back()->with('error', 'Veuillez spécifier au moins un numéro de destinataire.');
        }

        $montantParPersonne = $montantSaisi / $nombreDestinataires;
        if ($montantParPersonne < 100) {
            return redirect()->back()->with('error', 'Le montant après division est inférieur au minimum requis (100 Ar par personne).');
        }

        $prefixModel = new PrefixModel();
        $prefixeEmetteur = substr($telephoneExpediteur, 0, 3);

        $destinatairesValibles = [];
        $totalFraisTransfertGlobal = 0.0;
        $totalFraisRetraitGlobal = 0.0;

        foreach ($destinatairesNumeros as $numero) {
            if ($numero === $telephoneExpediteur) {
                return redirect()->back()->with('error', 'Transaction annulée : Vous ne pouvez pas faire un transfert vers votre propre numéro.');
            }

            if (!$prefixModel->isPrefixAllowed($numero)) {
                return redirect()->back()->with('error', 'Transaction annulée : Le numéro ' . $numero . ' possède un préfixe non supporté.');
            }

            $prefixeDestinataire = substr($numero, 0, 3);
            $memeOperateur = ($prefixeEmetteur === $prefixeDestinataire);

            if ($nombreDestinataires > 1 && !$memeOperateur) {
                return redirect()->back()->with('error', 'Transaction annulée : L\'envoi multiple est restreint au même opérateur.');
            }

            try {
                $tarificationTransfert = $this->getTarification('transfert', $montantParPersonne);
                $fraisTransfert = $tarificationTransfert['frais'];
            } catch (\RuntimeException $e) {
                return redirect()->back()->with('error', 'Erreur barème transfert : ' . $e->getMessage());
            }

            $totalFraisTransfertGlobal += $fraisTransfert;

            $fraisRetraitOfferts = 0.0;
            if ($inclureFraisRetrait && $memeOperateur) {
                try {
                    $tarificationRetrait = $this->getTarification('retrait', $montantParPersonne);
                    $fraisRetraitOfferts = $tarificationRetrait['frais'];
                } catch (\RuntimeException $e) {
                    return redirect()->back()->with('error', 'Erreur barème retrait : ' . $e->getMessage());
                }
            }

            $totalFraisRetraitGlobal += $fraisRetraitOfferts;

            $destinataire = $clientModel->findByTelephone($numero);
            if (!$destinataire) {
                $destinataire = $clientModel->getOrCreateByTelephone($numero);
            }

            $montantCreditDestinataire = $this->computeRecipientCreditAmount($montantParPersonne, $fraisRetraitOfferts, $inclureFraisRetrait && $memeOperateur);

            $destinatairesValibles[] = [
                'record' => $destinataire,
                'montant_brut' => $montantParPersonne,
                'frais_transfert' => $fraisTransfert,
                'frais_retrait_inclus' => $fraisRetraitOfferts,
                'montant_total_recu' => $montantCreditDestinataire,
            ];
        }

        $coutTotalExpediteur = $montantSaisi + $totalFraisTransfertGlobal + $totalFraisRetraitGlobal;

        if ($expediteur['solde'] < $coutTotalExpediteur) {
            return redirect()->back()->with('error', 'Solde insuffisant.');
        }

        // Débit exact de l'expéditeur
        $clientModel->update($expediteur['id'], ['solde' => $expediteur['solde'] - $coutTotalExpediteur]);

        // Crédit exact du destinataire
        foreach ($destinatairesValibles as $cible) {
            $clientModel->update($cible['record']['id'], [
                'solde' => $cible['record']['solde'] + $cible['montant_total_recu']
            ]);

            // Correction critique : Si l'option est cochée, on insère la valeur distinctive 99999
            $fraisMarquage = ($inclureFraisRetrait && $memeOperateur) ? 99999 : $cible['frais_transfert'];

            $this->saveTransaction($expediteur['id'], 'transfert', $cible['montant_brut'], $fraisMarquage, $cible['record']['id']);
        }

        return redirect()->to('/client/dashboard#nav-transfert')->with('success', 'Transfert effectué avec succès !');
    }

    public function resolveRetraitFees(float $fraisRetraitTheoriques, ?array $transfertRecu): array
    {
        // Si on trouve un transfert lié avec la valeur 99999, c'est que les frais sont prépayés !
        if ($transfertRecu && floatval($transfertRecu['frais_appliques']) === 99999.0) {
            return [
                'frais_appliques' => 0.0,
                'deja_paye_par_expediteur' => true,
            ];
        }

        return [
            'frais_appliques' => (float) $fraisRetraitTheoriques,
            'deja_paye_par_expediteur' => false,
        ];
    }

    public function computeRecipientCreditAmount(float $montantBrut, float $fraisRetraitOfferts, bool $inclureFraisRetrait): float
    {
        if ($inclureFraisRetrait) {
            return $montantBrut + $fraisRetraitOfferts;
        }

        return $montantBrut;
    }

    private function getTarification(string $operationName, float $montant): array
    {
        $baremeModel = new BaremeModel();
        $bareme = $baremeModel->getBaremeForOperation($operationName, $montant);

        if (!$bareme) {
            throw new \RuntimeException('Aucun barème trouvé.');
        }

        return [
            'frais' => (float) $bareme['frais'],
            'type_op_id' => $baremeModel->getTypeOperationId($operationName),
        ];
    }

    private function saveTransaction(int $clientId, string $operationName, float $montant, float $frais, ?int $destinationClientId = null): void
    {
        $baremeModel = new BaremeModel();
        $typeOpId = $baremeModel->getTypeOperationId($operationName);

        if ($typeOpId === null) {
            return;
        }

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
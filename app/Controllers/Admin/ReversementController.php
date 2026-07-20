<?php

namespace App\Controllers\Admin;

use App\Models\TransactionModel;
use App\Models\PrefixModel;

class ReversementController extends BaseAdminController
{
    public function index()
    {
        $db = db_connect();
        $prefixModel = new PrefixModel();
        $transactionModel = new TransactionModel();

        // Opérateur courant
        $operateurCourant = $db->table('operateur_courant')->get()->getRowArray();

        // Tous les opérateurs tiers (préfixes)
        $operateurs = $prefixModel->findAll();

        // Pourcentage de frais de gestion (configurable via session ou GET)
        $fraisGestionPct = (float) $this->request->getGet('frais_gestion_pct');
        if ($fraisGestionPct <= 0) {
            $fraisGestionPct = 10; // 10% par défaut
        }

        $reversements = [];
        $totalGlobal = 0;
        $totalFraisGlobal = 0;
        $totalCommissionGlobal = 0;
        $totalReversementGlobal = 0;

        foreach ($operateurs as $op) {
            $prefixe = $op['code'];
            $data = $transactionModel->getReversementParOperateur($prefixe);

            $totalMontant = (float) $data['total_montant'];
            $totalFrais = (float) $data['total_frais'];
            $nbTransactions = (int) $data['nombre_transactions'];

            // Commission de gestion = % des frais collectés que l'opérateur courant garde
            $commissionGestion = $totalFrais * ($fraisGestionPct / 100);
            $montantReverser = $totalMontant - $commissionGestion;

            // Ne pas afficher si aucune transaction
            if ($nbTransactions === 0) {
                continue;
            }

            $reversements[] = [
                'operateur_nom'     => $op['operateur_nom'] ?: $prefixe,
                'prefixe'           => $prefixe,
                'total_montant'     => $totalMontant,
                'total_frais'       => $totalFrais,
                'commission_gestion' => $commissionGestion,
                'montant_reverser'  => $montantReverser,
                'nb_transactions'   => $nbTransactions,
            ];

            $totalGlobal += $totalMontant;
            $totalFraisGlobal += $totalFrais;
            $totalCommissionGlobal += $commissionGestion;
            $totalReversementGlobal += $montantReverser;
        }

        $data = [
            'operateurCourant'      => $operateurCourant,
            'reversements'          => $reversements,
            'fraisGestionPct'       => $fraisGestionPct,
            'totalGlobal'           => $totalGlobal,
            'totalFraisGlobal'      => $totalFraisGlobal,
            'totalCommissionGlobal' => $totalCommissionGlobal,
            'totalReversementGlobal'=> $totalReversementGlobal,
        ];

        return $this->render('admin/reversement/index', $data, 'Reversements');
    }
}

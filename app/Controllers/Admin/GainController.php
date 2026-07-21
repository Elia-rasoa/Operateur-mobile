<?php

namespace App\Controllers\Admin;

use App\Models\TransactionModel;

class GainController extends BaseAdminController
{
    public function index()
    {
        $model = new TransactionModel();
        $db = db_connect();

        // Gains par type de réseau
        $gainsParReseau = $model->getGainsParReseau();
        $gainsInternes = 0;
        $gainsExternes = 0;
        foreach ($gainsParReseau as $g) {
            if ($g['type_reseau'] === 'interne') {
                $gainsInternes = (float) $g['total_gains'];
            } elseif ($g['type_reseau'] === 'externe') {
                $gainsExternes = (float) $g['total_gains'];
            }
        }

        // Commission interconnexion totale (commission_externe_pct * montant)
        $builder = $db->table('transactions t');
        $builder->select('COALESCE(SUM(t.montant * b.commission_externe_pct / 100), 0) as total_commission');
        $builder->join('baremes b', 'b.type_op_id = t.type_op_id', 'left');
        $builder->where('t.type_reseau', 'externe');
        $commissionInterconnexion = (float) $builder->get()->getRowArray()['total_commission'];

        // Filtrer par date
        $date_debut = $this->request->getGet('date_debut');
        $date_fin = $this->request->getGet('date_fin');

        $data = [
            'gainsInternes'          => $gainsInternes,
            'gainsExternes'          => $gainsExternes,
            'commissionInterconnexion' => $commissionInterconnexion,
            'totalGains'             => $gainsInternes + $gainsExternes + $commissionInterconnexion,
            'date_debut'             => $date_debut,
            'date_fin'               => $date_fin,
        ];

        return $this->render('admin/gains/index', $data, 'Gains et Commissions');
    }
}

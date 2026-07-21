<?php

namespace App\Controllers\Admin;

use App\Models\TransactionModel;

class DashboardController extends BaseAdminController
{
    public function index()
    {
        $db = db_connect();
        $transactionModel = new TransactionModel();

        $gainsParReseau = $transactionModel->getGainsParReseau();
        $gainsInternes = 0;
        $gainsExternes = 0;
        foreach ($gainsParReseau as $g) {
            if ($g['type_reseau'] === 'interne') {
                $gainsInternes = (float) $g['total_gains'];
            } elseif ($g['type_reseau'] === 'externe') {
                $gainsExternes = (float) $g['total_gains'];
            }
        }

        $data = [
            'totalClients'      => $db->table('clients')->countAllResults(),
            'totalPrefixes'     => $db->table('prefixes')->countAllResults(),
            'totalBaremes'      => $db->table('baremes')->countAllResults(),
            'totalTransactions' => $db->table('transactions')->countAllResults(),
            'soldeTotal'        => (float) ($db->table('clients')->selectSum('solde')->get()->getRow()->solde ?? 0),
            'totalGains'        => (float) ($db->table('transactions')->selectSum('frais_appliques')->get()->getRow()->frais_appliques ?? 0),
            'gainsInternes'     => $gainsInternes,
            'gainsExternes'     => $gainsExternes,
        ];

        return $this->render('admin/dashboard/index', $data, 'Tableau de bord');
    }
}

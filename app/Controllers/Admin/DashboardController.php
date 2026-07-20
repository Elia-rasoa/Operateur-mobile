<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        $db = db_connect();

        $data = [
            'totalClients'      => $db->table('clients')->countAllResults(),
            'totalPrefixes'     => $db->table('prefixes')->countAllResults(),
            'totalBaremes'      => $db->table('baremes')->countAllResults(),
            'totalTransactions' => $db->table('transactions')->countAllResults(),
            'soldeTotal'        => (float) ($db->table('clients')->selectSum('solde')->get()->getRow()->solde ?? 0),
            'totalGains'        => (float) ($db->table('transactions')->selectSum('frais_appliques')->get()->getRow()->frais_appliques ?? 0),
        ];

        return view('admin/dashboard/index', $data);
    }
}

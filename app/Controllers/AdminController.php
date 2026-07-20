<?php

namespace App\Controllers;

use App\Models\client\TransactionModel;

class AdminController extends BaseController
{
    public function historique()
    {
        $transactionModel = new TransactionModel();
        $transactions = $transactionModel->getHistorique();

        $data = [
            'transactions' => $transactions
        ];

        return view('admin/clients/historique', $data);
    }
}


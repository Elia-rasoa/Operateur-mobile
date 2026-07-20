<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ClientModel;

class ClientController extends BaseController
{
    public function index()
    {
        $model = new ClientModel();
        $data['clients'] = $model->getAllWithSolde();
        return view('admin/clients/index', $data);
    }

    public function historique($id)
    {
        $model = new ClientModel();
        $client = $model->find($id);

        if (!$client) {
            return redirect()->to('/admin/clients')->with('error', 'Client introuvable.');
        }

        $data['client'] = $client;
        $data['transactions'] = $model->getClientTransactions($id);
        return view('admin/clients/historique', $data);
    }
}

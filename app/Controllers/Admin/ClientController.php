<?php

namespace App\Controllers\Admin;

use App\Models\ClientModel;

class ClientController extends BaseAdminController
{
    public function index()
    {
        $model = new ClientModel();
        $data['clients'] = $model->getAllWithSolde();
        return $this->render('admin/clients/index', $data, 'Gestion des Clients');
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
        return $this->render('admin/clients/historique', $data, 'Historique - ' . ($client['numero_telephone'] ?? $client['telephone'] ?? 'Client'));
    }
}

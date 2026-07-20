<?php

namespace App\Controllers;

use App\Models\client\ClientModel;
use App\Models\client\PrefixModel;

class Login extends BaseController
{
    public function index() 
    {
        if (session()->has('client_id')) {
            return redirect()->to('/client/dashboard');
        }

        return view('login/index');
    }

    public function authentifier() 
    {
        $phone = $this->request->getPost('telephone');

        // 1. Extraction et vérification du préfixe
        $prefixCode = substr($phone, 0, 3);
        $prefixModel = new PrefixModel();
        $prefixExiste = $prefixModel->where('code', $prefixCode)->first();

        if (!$prefixExiste) {
            return redirect()->to('/')->with('error', 'Opérateur non supporté ou préfixe invalide.');
        }

        // 2. Récupération ou création automatique du client
        $clientModel = new ClientModel();
        $client = $clientModel->where('numero_telephone', $phone)->first();

        if (!$client) {
            // Le modèle va intercepter cette insertion et ajouter le 'created_at' automatiquement !
            $newClientData = [
                'numero_telephone' => $phone,
                'solde'            => 0.0
            ];
            $clientId = $clientModel->insert($newClientData);
        } else {
            $clientId = $client['id'];
        }

        // 3. Stockage en session
        $session = session();
        $session->set([
            'client_id'    => $clientId,
            'client_phone' => $phone
        ]);

        return redirect()->to('/client/dashboard')->with('success', 'Connexion réussie.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
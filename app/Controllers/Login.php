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
    $phone = trim($this->request->getPost('telephone'));

    // 1. Vérification : le numéro doit faire exactement 10 chiffres
    if (strlen($phone) !== 10 || !ctype_digit($phone)) {
        return redirect()->to('/')->with('error', 'Le numéro de téléphone doit contenir exactement 10 chiffres.');
    }

    // 2. Vérification du préfixe opérateur
    $prefixModel = new PrefixModel();
    if (!$prefixModel->isPrefixAllowed($phone)) {
        return redirect()->to('/')->with('error', 'Opérateur non supporté ou préfixe invalide.');
    }

    // 3. Récupération ou création du client
    $clientModel = new ClientModel();
    $client = $clientModel->findByTelephone($phone);

    if (!$client) {
        $client = $clientModel->getOrCreateByTelephone($phone);
    }

    $clientId = $client['id'];

    // 4. Stockage en session
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
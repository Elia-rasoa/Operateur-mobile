<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class AuthController extends BaseController
{
    public function login()
    {
        // Si déjà connecté, rediriger vers le dashboard
        if (session()->has('admin_logged_in')) {
            return redirect()->to('/admin');
        }
        return view('admin/login');
    }

    public function authenticate()
    {
        $identifiant = $this->request->getPost('identifiant');
        $motDePasse = $this->request->getPost('mot_de_passe');

        // Identifiants par défaut (à changer en production)
        if ($identifiant === 'admin' && $motDePasse === 'admin123') {
            session()->set('admin_logged_in', true);
            return redirect()->to('/admin')->with('message', 'Bienvenue dans l\'administration.');
        }

        return redirect()->to('/admin/login')->with('error', 'Identifiant ou mot de passe incorrect.');
    }

    public function logout()
    {
        session()->remove('admin_logged_in');
        return redirect()->to('/admin/login')->with('message', 'Vous êtes déconnecté.');
    }
}

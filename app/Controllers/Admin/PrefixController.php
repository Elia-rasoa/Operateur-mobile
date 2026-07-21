<?php

namespace App\Controllers\Admin;

use App\Models\PrefixModel;

class PrefixController extends BaseAdminController
{
    public function index()
    {
        $model = new PrefixModel();
        $data['prefixes'] = $model->findAll();

        // Récupérer l'opérateur courant
        $db = db_connect();
        $data['operateur_courant'] = $db->table('operateur_courant')->get()->getRowArray();

        return $this->render('admin/prefixes/index', $data, 'Gestion des Préfixes');
    }

    public function add()
    {
        $model = new PrefixModel();
        $code = $this->request->getPost('code');
        $operateurNom = $this->request->getPost('operateur_nom');

        if (empty($code)) {
            return redirect()->to('/admin/prefixes')->with('error', 'Le code préfixe est requis.');
        }

        $existing = $model->where('code', $code)->first();
        if ($existing) {
            return redirect()->to('/admin/prefixes')->with('error', 'Ce préfixe existe déjà.');
        }

        $model->insert([
            'code' => $code,
            'operateur_nom' => $operateurNom ?: null,
        ]);
        return redirect()->to('/admin/prefixes')->with('message', 'Préfixe ajouté avec succès !');
    }

    public function delete($id)
    {
        $model = new PrefixModel();
        $model->delete($id);
        return redirect()->to('/admin/prefixes')->with('message', 'Préfixe supprimé avec succès !');
    }

    /**
     * Mise à jour de l'opérateur courant
     */
    public function updateOperateurCourant()
    {
        $nom = $this->request->getPost('nom_operateur');
        $prefixe = $this->request->getPost('prefixe');

        if (empty($nom) || empty($prefixe)) {
            return redirect()->to('/admin/prefixes')->with('error', 'Tous les champs sont requis.');
        }

        $db = db_connect();
        $existing = $db->table('operateur_courant')->get()->getRowArray();

        if ($existing) {
            $db->table('operateur_courant')->update([
                'nom_operateur' => $nom,
                'prefixe' => $prefixe,
            ], ['id' => $existing['id']]);
        } else {
            $db->table('operateur_courant')->insert([
                'nom_operateur' => $nom,
                'prefixe' => $prefixe,
            ]);
        }

        return redirect()->to('/admin/prefixes')->with('message', 'Opérateur courant mis à jour avec succès !');
    }
}

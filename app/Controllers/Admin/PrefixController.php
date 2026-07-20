<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PrefixModel;

class PrefixController extends BaseController
{
    public function index()
    {
        $model = new PrefixModel();
        $data['prefixes'] = $model->findAll();
        return view('admin/prefixes/index', $data);
    }

    public function add()
    {
        $model = new PrefixModel();
        $code = $this->request->getPost('code');

        if (empty($code)) {
            return redirect()->to('/admin/prefixes')->with('error', 'Le code préfixe est requis.');
        }

        $existing = $model->where('code', $code)->first();
        if ($existing) {
            return redirect()->to('/admin/prefixes')->with('error', 'Ce préfixe existe déjà.');
        }

        $model->insert(['code' => $code]);
        return redirect()->to('/admin/prefixes')->with('message', 'Préfixe ajouté avec succès !');
    }

    public function delete($id)
    {
        $model = new PrefixModel();
        $model->delete($id);
        return redirect()->to('/admin/prefixes')->with('message', 'Préfixe supprimé avec succès !');
    }
}

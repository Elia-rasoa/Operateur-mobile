<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BaremeModel;

class BaremeController extends BaseController
{
    public function index()
    {
        $model = new BaremeModel();
        $data['baremes'] = $model->getBaremesWithTypes();
        return view('admin/baremes/index', $data);
    }

    public function update($id)
    {
        $model = new BaremeModel();
        $model->update($id, [
            'frais' => $this->request->getPost('frais')
        ]);
        return redirect()->to('/admin/baremes')->with('message', 'Frais mis à jour avec succès !');
    }
}
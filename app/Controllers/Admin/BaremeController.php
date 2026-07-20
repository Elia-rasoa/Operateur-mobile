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
        $data['types_operation'] = $model->getTypesOperation();
        return view('admin/baremes/index', $data);
    }

    public function update($id)
    {
        $model = new BaremeModel();
        $model->update($id, [
            'type_op_id'   => $this->request->getPost('type_op_id'),
            'montant_min'  => $this->request->getPost('montant_min'),
            'montant_max'  => $this->request->getPost('montant_max'),
            'frais'        => $this->request->getPost('frais'),
        ]);
        return redirect()->to('/admin/baremes')->with('message', 'Barème mis à jour avec succès !');
    }

    public function add()
    {
        $model = new BaremeModel();
        $model->addBareme([
            'type_op_id'   => $this->request->getPost('type_op_id'),
            'montant_min'  => $this->request->getPost('montant_min'),
            'montant_max'  => $this->request->getPost('montant_max'),
            'frais'        => $this->request->getPost('frais'),
        ]);
        return redirect()->to('/admin/baremes')->with('message', 'Nouveau barème ajouté avec succès !');
    }

    public function delete($id)
    {
        $model = new BaremeModel();
        $model->deleteBareme($id);
        return redirect()->to('/admin/baremes')->with('message', 'Barème supprimé avec succès !');
    }
}

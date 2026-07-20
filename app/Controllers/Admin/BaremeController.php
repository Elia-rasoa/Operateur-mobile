<?php

namespace App\Controllers\Admin;

use App\Models\BaremeModel;

class BaremeController extends BaseAdminController
{
    public function index()
    {
        $model = new BaremeModel();
        $data['baremes'] = $model->getBaremesWithTypes();
        $data['types_operation'] = $model->getTypesOperation();
        return $this->render('admin/baremes/index', $data, 'Gestion des Barèmes');
    }

    public function update($id)
    {
        $model = new BaremeModel();
        $data = [
            'type_op_id'   => $this->request->getPost('type_op_id'),
            'montant_min'  => $this->request->getPost('montant_min'),
            'montant_max'  => $this->request->getPost('montant_max'),
            'frais'        => $this->request->getPost('frais'),
        ];

        $commission = $this->request->getPost('commission_externe_pct');
        if ($commission !== null) {
            $data['commission_externe_pct'] = (float) $commission;
        }

        $model->update($id, $data);
        return redirect()->to('/admin/baremes')->with('message', 'Barème mis à jour avec succès !');
    }

    public function add()
    {
        $model = new BaremeModel();
        $data = [
            'type_op_id'   => $this->request->getPost('type_op_id'),
            'montant_min'  => $this->request->getPost('montant_min'),
            'montant_max'  => $this->request->getPost('montant_max'),
            'frais'        => $this->request->getPost('frais'),
        ];

        $commission = $this->request->getPost('commission_externe_pct');
        if ($commission !== null) {
            $data['commission_externe_pct'] = (float) $commission;
        }

        $model->addBareme($data);
        return redirect()->to('/admin/baremes')->with('message', 'Nouveau barème ajouté avec succès !');
    }

    public function delete($id)
    {
        $model = new BaremeModel();
        $model->deleteBareme($id);
        return redirect()->to('/admin/baremes')->with('message', 'Barème supprimé avec succès !');
    }
}

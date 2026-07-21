<?php

namespace App\Controllers\Admin;

use App\Models\TransactionModel;
use App\Models\BaremeModel;

class TransactionController extends BaseAdminController
{
    public function index()
    {
        $model = new TransactionModel();
        $baremeModel = new BaremeModel();

        // Filtres
        $type_op_id = $this->request->getGet('type_op_id');
        $date_debut = $this->request->getGet('date_debut');
        $date_fin = $this->request->getGet('date_fin');
        $type_reseau = $this->request->getGet('type_reseau');

        $data['transactions'] = $model->getFilteredTransactions($type_op_id, $date_debut, $date_fin, $type_reseau);
        $data['types_operation'] = $baremeModel->getTypesOperation();
        $data['total_gains'] = $model->getTotalGains($type_op_id, $type_reseau);

        // Valeurs des filtres pour réafficher
        $data['filter_type'] = $type_op_id;
        $data['filter_debut'] = $date_debut;
        $data['filter_fin'] = $date_fin;
        $data['filter_reseau'] = $type_reseau;

        return $this->render('admin/transactions/index', $data, 'Suivi des Transactions');
    }
}

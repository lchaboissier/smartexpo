<?php

namespace App\Controllers;

use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;

class Exposant extends BaseController
{
    protected $model;

    public function __construct()
    {
        helper('form');
        $this->model = model(Db_model::class);
    }

    public function afficher($code)
    {
        $this->model = model(Db_model::class);

        $data['cfg'] = $this->model->get_configuration();
        $data['exposant'] = $this->model->get_exposant($code);

        return view('templates/haut', $data)
            . view('templates/menu_visiteur')
            . view('templates/affichage_exposant')
            . view('templates/bas');
    }
}

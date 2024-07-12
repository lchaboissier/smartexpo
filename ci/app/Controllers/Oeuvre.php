<?php

namespace App\Controllers;

use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;

class Oeuvre extends BaseController
{
    protected $model;

    public function __construct()
    {
        helper('form');
        $this->model = model(Db_model::class);
    }

    public function lister()
    {
        $this->model = model(Db_model::class);
        $data['cfg'] = $this->model->get_configuration();
        $data['titre'] = "Galerie des oeuvres";
        $data['oeuvres'] = $this->model->get_all_oeuvres();
        return view('templates/haut', $data)
            . view('templates/menu_visiteur')
            . view('templates/lister_oeuvre')
            . view('templates/bas');
    }

    public function afficher($code)
    {
        $this->model = model(Db_model::class);

        $data['cfg'] = $this->model->get_configuration();
        $data['oeuvre'] = $this->model->get_oeuvre($code);

        return view('templates/haut', $data)
            . view('templates/menu_visiteur')
            . view('templates/affichage_oeuvre')
            . view('templates/bas');
    }
}

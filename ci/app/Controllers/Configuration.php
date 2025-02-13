<?php

namespace App\Controllers;

use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;

class Configuration extends BaseController
{
    public function __construct()
    {
        //...
    }

    public function afficher()
    {
        $model = model(Db_model::class);

        $data['cfg'] = $model->get_configuration();
		$data['dateVernissage'] = $model->get_dateVernissage_configuration();
        return view('templates/haut', $data)
			. view('templates/menu_visiteur')
			. view('templates/affichage_accueil')
			. view('templates/bas');
    }

    // public function afficher($donnee)
    // {
    // 	$data['parametre_url'] = ($donnee);

    // 	return view('templates/haut', $data)
    // 		. view('templates/affichage_accueil')
    // 		. view('templates/bas');
    // }

}

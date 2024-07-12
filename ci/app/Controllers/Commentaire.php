<?php

namespace App\Controllers;

use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;

class Commentaire extends BaseController
{
	public function __construct()
	{
		//...
	}

	public function lister()
	{
		$model = model(Db_model::class);
        $data['cfg'] = $model->get_configuration();
		$data['titre'] = "Livre d'or de l'exposition";
		$data['commentaires'] = $model->get_all_commentaire();
		return view('templates/haut', $data)
        . view('templates/menu_visiteur')
			. view('templates/affichage_livre_dor')
			. view('templates/bas');
	}
}

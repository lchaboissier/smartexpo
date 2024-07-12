<?php

namespace App\Controllers;

use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;

class Bootstrap extends BaseController
{
	public function afficher(): string
	{
		$model = model(Db_model::class);

		$data['cfg'] = $model->get_configuration();
		return view('templates/haut', $data)
			. view('templates/menu_visiteur')
			. view('templates/affichage_bootstrap')
			. view('templates/bas');
	}
}

<?php

namespace App\Controllers;

use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;

class Admin extends BaseController
{
	protected $model;

	public function __construct()
	{
		helper('form');
		$this->model = model(Db_model::class);
	}

	public function afficher()
	{
		$model = model(Db_model::class);

		$session = session();
		$data['cfg'] = $this->model->get_configuration();

		if ($session->has('administrateur')) {
			$compte = $session->get('administrateur');
			$profil = $this->model->get_profil($compte);
			$data['profil'] = $profil;
			return view('templates/haut_admin', $data)
				. view('templates/menu_administrateur', $data)
				. view('templates/affichage_admin')
				. view('templates/bas_admin');
		} elseif ($session->has('organisateur')) {
			$compte = $session->get('organisateur');
			$profil = $this->model->get_profil($compte);
			$data['profil'] = $profil;
			return view('templates/haut_admin', $data)
				. view('templates/menu_organisateur', $data)
				. view('templates/affichage_admin')
				. view('templates/bas_admin');
		} else {
			return view('templates/haut_admin', ['titre' => 'Se connecter'], $data)
				. view('templates/connexion/compte_connecter');
			// . view('templates/bas', $data);
		}
	}

	// public function afficher($donnee)
	// {
	// 	$data['parametre_url'] = ($donnee);

	// 	return view('templates/haut', $data)
	// 		. view('templates/affichage_accueil')
	// 		. view('templates/bas');
	// }

}

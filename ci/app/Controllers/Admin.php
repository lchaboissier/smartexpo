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
		$data['titre'] = "Se connecter";
		$data['page'] = "Tableau de bord";
		$data['cfg'] = $this->model->get_configuration();

		if ($session->has('administrateur')) {
			$compte = $session->get('administrateur');
			$profil = $this->model->get_profil($compte);
			$data['nbTotalProfils'] = $this->model->get_count_all_profils();
			$data['nbTotalActus'] = $this->model->get_count_all_actualites();
			$data['nbTotalTicketsVst'] = $this->model->get_count_all_tickets();
			$data['nbTotalCommentaires'] = $this->model->get_count_all_commentaires();
			// Vérifier si le profil est valide
			if ($profil && $profil->pro_validite == 'A') {
				$data['profil'] = $profil;
				return view('templates/haut_admin', $data)
					. view('templates/menu_administrateur', $data)
					. view('templates/affichage_admin', $data)
					. view('templates/bas_admin');
			} else {
				// Rediriger vers la page de connexion avec un message flash
				$session->setFlashdata('error', 'Votre compte n\'est pas activé. Veuillez contacter le service d\'administration.');
				return view('templates/haut_admin', $data)
						. view('templates/connexion/compte_connecter');
			}
		} elseif ($session->has('organisateur')) {
			$compte = $session->get('organisateur');
			$profil = $this->model->get_profil($compte);
			$data['nbTotalActus'] = $this->model->get_count_all_actualites();
			$data['nbTotalTicketsVst'] = $this->model->get_count_all_tickets();
			$data['nbTotalCommentaires'] = $this->model->get_count_all_commentaires();
			// Vérifier si le profil de l'organisateur est valide
			if ($profil && $profil->pro_validite == 'A') {
				$data['profil'] = $profil;
				return view('templates/haut_admin', $data)
					. view('templates/menu_organisateur', $data)
					. view('templates/affichage_admin')
					. view('templates/bas_admin');
			} else {
				// Rediriger vers la page de connexion avec un message flash
				$session->setFlashdata('error', 'Votre compte n\'est pas activé. Veuillez contacter le service d\'administration.');
				return view('templates/haut_admin', $data)
						. view('templates/connexion/compte_connecter');
			}
		} else {
			// Rediriger vers la page de connexion avec un message d'erreur
			$session->setFlashdata('error', 'Vous devez vous connecter pour accéder à cette page.');
			return view('templates/haut_admin', $data)
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

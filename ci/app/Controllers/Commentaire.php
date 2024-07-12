<?php

namespace App\Controllers;

use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;

class Commentaire extends BaseController
{
	protected $model;
	public function __construct()
	{
		helper('form');
		$this->model = model(Db_model::class);
	}

	public function lister()
	{
		$model = model(Db_model::class);
		$data['page'] = "Livre d'or";
		$data['cfg'] = $model->get_configuration();
		$data['titre'] = "Livre d'or de l'exposition";
		$data['commentaires'] = $model->get_all_commentaire();
		return view('templates/haut', $data)
			. view('templates/menu_visiteur')
			. view('templates/affichage_livre_dor')
			. view('templates/bas');
	}

	public function admin_lister()
	{
		$model = model(Db_model::class);
		$session = session();
		$data['cfg'] = $this->model->get_configuration();
		$data['titre'] = "Se connecter";
		$data['page'] = "Gestion des tickets";

		if ($session->has('administrateur')) {
			$compte = $session->get('administrateur');
			$profil = $this->model->get_profil($compte);

			// Vérifier si le profil de l'administrateur est valide
			if ($profil && $profil->pro_validite == 'A') {
				$data['cfg'] = $this->model->get_configuration();;
				$data['tickets'] = $this->model->get_visiteurs_commentaire();
				$data['profil'] = $profil;
				$data['titre'] = "Liste des tickets visiteurs";

				return view('templates/haut_admin', $data)
					. view('templates/menu_administrateur')
					. view('templates/affichage_tickets')
					. view('templates/bas_admin');
			} else {
				$session->setFlashdata('error', 'Votre compte n\'est pas activé. Veuillez contacter le service d\'administration.');
				// Rediriger vers la page de connexion avec un message d'erreur
				return view('templates/haut_admin', $data)
					. view('templates/connexion/compte_connecter');
				// . view('templates/bas_admin', $data);
			}
		} elseif($session->has('organisateur')) {
			$data['titre'] = "Se connecter";
			$compte = $session->get('organisateur');
			$profil = $this->model->get_profil($compte);

			// Vérifier si le profil de l'administrateur est valide
			if ($profil && $profil->pro_validite == 'A') {
				$data['cfg'] = $this->model->get_configuration();;
				$data['tickets'] = $this->model->get_visiteurs_commentaire();
				$data['profil'] = $profil;
				$data['titre'] = "Liste des tickets visiteurs";

				return view('templates/haut_admin', $data)
					. view('templates/menu_organisateur')
					. view('templates/affichage_tickets')
					. view('templates/bas_admin');
			} else {
				$session->setFlashdata('error', 'Votre compte n\'est pas activé. Veuillez contacter le service d\'administration.');
				// Rediriger vers la page de connexion avec un message d'erreur
				return view('templates/haut_admin', $data)
					. view('templates/connexion/compte_connecter');
				// . view('templates/bas_admin', $data);
			}
		} else {
			// Rediriger vers la page de connexion avec un message d'erreur
			$session->setFlashdata('error', 'Vous devez vous connecter pour accéder à cette page.');
			return view('templates/haut_admin', $data)
				. view('templates/connexion/compte_connecter');
			// . view('templates/bas', $data);
		}
	}

	public function supprimer_ticket()
    {
		// Récupération des données de configuration
		$data['page'] = "Gestion des tickets";
		$data['cfg'] = $this->model->get_configuration();
		$data['titre'] = "Se connecter";
		$vst_num = $this->request->getPost('vst_num');
        // Vérifier si l'utilisateur est autorisé à effectuer cette action (vous pouvez ajouter votre logique d'autorisation ici)
		$session = session();

		// Vérification de l'authentification de l'organisateur
		if (!$session->has('organisateur')) {
			// Redirection vers la page de connexion ou affichage d'un message d'erreur
			return view('templates/haut_admin', $data)
				. view('templates/connexion/compte_connecter');
		}

        // Supprimer les données du visiteur avec le commentaire associé
        $resultat = $this->model->delete_visiteur_commentaire($vst_num);

		if ($resultat) {
			$session->setFlashdata('message', 'Les données du ticket visiteur ont bien été supprimé.');
		} else {
			$session->setFlashdata('error', 'Une erreur s\'est produite lors de la suppression des données du ticket visiteur.');
		}
        // Rediriger vers une page de confirmation ou une autre page appropriée
		return redirect()->to(current_url());
    }
}

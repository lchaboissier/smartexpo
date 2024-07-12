<?php

namespace App\Controllers;

use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;

class Compte extends BaseController
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
		$data['nbTotalComptes'] = $this->model->get_count_all_compte();
		$data['titre'] = "Liste de tous les comptes";
		$data['logins'] = $this->model->get_all_compte();
		return view('templates/haut', $data)
			. view('templates/menu_visiteur')
			. view('templates/affichage_comptes')
			. view('templates/bas');
	}

	public function creer()
	{
		$data = [
			'le_compte' => '',
			'le_message' => '',
			'nbTotalComptes' => 0
		];

		// L’utilisateur a validé le formulaire en cliquant sur le bouton
		if ($this->request->getMethod() == "post") {
			if (!$this->validate(
				[
					'cpt_email' => 'required|max_length[255]|min_length[2]|valid_email|is_unique[t_compte_cpt.cpt_email]',
					'cpt_motdepasse' => 'required|max_length[255]|min_length[8]',
					'cpt_image' => [
						'label' => 'Fichier image',
						'rules' => [
							'uploaded[cpt_image]',
							'is_image[cpt_image]',
							'mime_in[cpt_image,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
							'max_size[cpt_image,100]',
							'max_dims[cpt_image,1024,768]',
						]
					]
				],
				[ // Configuration des messages d’erreurs
					'cpt_email' => [
						'required' => 'Veuillez entrer une adresse email pour le compte !',
						'valid_email' => 'Veuillez entrer une adresse email valide !',
						'is_unique' => 'Cette adresse email est déjà utilisée !'
					],
					'cpt_motdepasse' => [
						'required' => 'Veuillez entrer un mot de passe !',
						'min_length' => 'Le mot de passe saisi est trop court !',
					],
				]
			)) {
				// La validation du formulaire a échoué, retour au formulaire !
				return view('templates/haut_admin', ['titre' => 'Créer un compte', 'cfg' => $this->model->get_configuration()], $data)
					. view('templates/compte/compte_creer');
				// . view('templates/bas_admin');
			}
			// La validation du formulaire a réussi, traitement du formulaire
			$recuperation = $this->validator->getValidated();
			$email = $this->request->getVar('cpt_email');
			$motdepasse = $this->request->getVar('cpt_motdepasse');
			$fichier = $this->request->getFile('cpt_image');
			if (!empty($fichier)) {
				// On récupère le nom du fichier téléversé
				$nom_fichier = $fichier->getName();
				// On vérifie si le nom du fichier existe déjà dans le dossier public/images
				if (file_exists("images/$nom_fichier")) {
					// Générer un nouveau nom de fichier unique
					$nom_fichier = $this->genererNomUnique($nom_fichier);
				}
				// On stocke l'image dans le répertoire public/images
				if ($fichier->move("images", $nom_fichier)) {
					$this->model->set_compte($email, $motdepasse, $nom_fichier);
					$data['le_compte'] = $recuperation['cpt_email'];
					$data['le_message'] = "Nouveau nombre de comptes : ";
					$data['nbTotalComptes'] = $this->model->get_count_all_compte();
					return view('templates/haut_admin', ['cfg' => $this->model->get_configuration()], $data)
						. view('templates/compte/compte_succes', $data)
						. view('templates/bas_admin');
				}
			}
		}

		// L’utilisateur veut afficher le formulaire pour créer un compte
		return view('templates/haut_admin', ['titre' => 'Créer un compte', 'cfg' => $this->model->get_configuration()], $data)
			. view('templates/compte/compte_creer');
		// . view('templates/bas_admin');
	}

	private function genererNomUnique($nom_fichier)
	{
		$extension = pathinfo($nom_fichier, PATHINFO_EXTENSION);
		$nom_base = pathinfo($nom_fichier, PATHINFO_FILENAME);
		$index = 1;
		$nouveauNom = $nom_base . "_$index.$extension";

		while (file_exists("images/$nouveauNom")) {
			$index++;
			$nouveauNom = $nom_base . "_$index.$extension";
		}

		return $nouveauNom;
	}

	public function connecter()
	{
		$data['cfg'] = $this->model->get_configuration();
		$data['titre'] = "Se connecter";

		// L’utilisateur a validé le formulaire en cliquant sur le bouton
		if ($this->request->getMethod() == "post") {
			if (!$this->validate([
				'pseudo' => 'required',
				'mdp' => 'required'
			])) { // La validation du formulaire a échoué, retour au formulaire !
				return view('templates/haut_admin', ['titre' => 'Se connecter'], $data)
					. view('templates/connexion/compte_connecter');
				// . view('templates/bas_admin', $data);
			}

			// La validation du formulaire a réussi, traitement du formulaire
			$username = $this->request->getVar('pseudo');
			$password = $this->request->getVar('mdp');

			if ($this->model->connect_compte($username, $password) == true) {
				$data['compte'] = $this->model->get_all_compte();
				$session = session();
				$statut = $this->model->get_profil_statut($username);
				if ($statut->pro_statut == 'A') {
					$session->set('administrateur', $username);
					$data['profil'] = $this->model->get_profil($username);
					return view('templates/haut_admin', $data)
						. view('templates/menu_administrateur', $data)
						. view('templates/connexion/compte_accueil')
						. view('templates/bas_admin', $data);
				} elseif ($statut->pro_statut == 'G') {
					$session->set('organisateur', $username);
					$data['profil'] = $this->model->get_profil($username);
					return view('templates/haut_admin', $data)
						. view('templates/menu_organisateur', $data)
						. view('templates/connexion/compte_accueil')
						. view('templates/bas_admin', $data);
				} else {
					return view('templates/haut_admin', ['titre' => 'Se connecter'], $data)
						. view('templates/connexion/compte_connecter');
				}
			} else {
				return view('templates/haut_admin', ['titre' => 'Se connecter'], $data)
					. view('templates/connexion/compte_connecter');
				// . view('templates/bas_admin', $data);
			}
		}
		// L’utilisateur veut afficher le formulaire pour se connecter
		return view('templates/haut_admin', ['titre' => 'Se connecter'], $data)
			. view('templates/connexion/compte_connecter');
		// . view('templates/bas_admin', $data);
	}

	public function afficher_profil()
	{
		$session = session();
		$data['cfg'] = $this->model->get_configuration();

		if ($session->has('administrateur')) {
			$compte = $session->get('administrateur');
			$data['le_message'] = "Affichage des données du profil ici !!!";
			// A COMPLETER...
			$profil = $this->model->get_profil($compte);
			$data['profil'] = $profil;
			return view('templates/haut_admin', $data)
				. view('templates/menu_administrateur', $data)
				. view('templates/connexion/compte_profil')
				. view('templates/bas_admin');
		} elseif ($session->has('organisateur')) {
			$compte = $session->get('organisateur');
			$data['le_message'] = "Affichage des données du profil ici !!!";
			// A COMPLETER...
			$profil = $this->model->get_profil($compte);
			$data['profil'] = $profil;
			return view('templates/haut_admin', ['titre' => 'Se connecter'], $data)
				. view('templates/menu_organisateur', $data)
				. view('templates/connexion/compte_profil')
				. view('templates/bas_admin', $data);
		} else {
			return view('templates/haut_admin', ['titre' => 'Se connecter'], $data)
				. view('templates/connexion/compte_connecter');
			// . view('templates/bas', $data);
		}
	}
	public function deconnecter()
	{
		$session = session();
		$session->setFlashdata('info', 'Vous avez bien été déconnecté.');
		$session->destroy();
		return view('templates/haut_admin', ['titre' => 'Se connecter'])
			. view('templates/connexion/compte_connecter');
		// . view('templates/bas');
	}
}

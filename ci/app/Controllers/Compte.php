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
		$session = session();
		$data['page'] = "Liste des profils";
		$data['titre'] = "Se connecter";
		$data['cfg'] = $this->model->get_configuration();

		if ($session->has('administrateur')) {
			$compte = $session->get('administrateur');
			$profil = $this->model->get_profil($compte);

			// Vérifier si le profil de l'administrateur est valide
			if ($profil && $profil->pro_validite == 'A') {
				$data['profil'] = $profil;
				$data['titre'] = "Liste de tous les profils";
				$data['nbTotalProfils'] = $this->model->get_count_all_profils();
				$data['logins'] = $this->model->get_all_profils();

				// Afficher la liste des profils
				return view('templates/haut_admin', $data)
					. view('templates/menu_administrateur', $data)
					. view('templates/affichage_comptes')
					. view('templates/bas_admin');
			} else {
				$session->setFlashdata('error', 'Votre compte n\'est pas activé. Veuillez contacter le service d\'administration.');
				// Rediriger vers la page de connexion avec un message d'erreur
				return view('templates/haut_admin', $data)
					. view('templates/connexion/compte_connecter');
				// . view('templates/bas_admin', $data);
			}
		} elseif ($session->has('organisateur')) {
			$compte = $session->get('organisateur');
			$profil = $this->model->get_profil($compte);
			$data['nbTotalProfils'] = $this->model->get_count_all_profils();
			$data['nbTotalActus'] = $this->model->get_count_all_actualites();
			$data['nbTotalTicketsVst'] = $this->model->get_count_all_tickets();
			$data['nbTotalCommentaires'] = $this->model->get_count_all_commentaires();
			if ($profil) {
				$data['profil'] = $profil;
				$session->setFlashdata('error', 'Vous n\'êtes pas autorisé à accéder à la liste des profils !');
				// Rediriger vers la page de connexion avec un message d'erreur
				return view('templates/haut_admin', $data)
					. view('templates/menu_organisateur', $data)
					. view('templates/affichage_admin')
					. view('templates/bas_admin');
			}
		} else {
			// Rediriger vers la page de connexion avec un message d'erreur
			$session->setFlashdata('error', 'Vous devez vous connecter pour accéder à cette page.');
			return view('templates/haut_admin', $data)
				. view('templates/connexion/compte_connecter');
			// . view('templates/bas_admin', $data);
		}
	}

	public function creer()
	{
		$data['le_compte'] = '';
		$data['le_message'] = '';
		$data['nbTotalComptes'] = 0;
		$data['titre'] = 'Inscription';
		$data['page'] = "Liste des profils";
		$data['cfg'] = $this->model->get_configuration();	

		// L’utilisateur a validé le formulaire en cliquant sur le bouton
		if ($this->request->getMethod() == "post") {
			if (!$this->validate(
				[
					'cpt_email' => 'required|max_length[255]|min_length[2]|valid_email|is_unique[t_compte_cpt.cpt_email]',
					'cpt_motdepasse' => 'required|max_length[255]|min_length[8]',
					'pro_image' => [
						'label' => 'Fichier image',
						'rules' => [
							'uploaded[pro_image]',
							'is_image[pro_image]',
							'mime_in[pro_image,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
							'max_size[pro_image,100]',
							'max_dims[pro_image,1024,768]',
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
				return view('templates/haut_admin', $data)
					. view('templates/compte/compte_creer');
				// . view('templates/bas_admin');
			}
			// La validation du formulaire a réussi, traitement du formulaire
			$recuperation = $this->validator->getValidated();
			$email = $this->request->getVar('cpt_email');
			$motdepasse = $this->request->getVar('cpt_motdepasse');
			$fichier = $this->request->getFile('pro_image');
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
					$data['nbTotalComptes'] = $this->model->get_count_all_profils();
					return view('templates/haut_admin', $data)
						. view('templates/compte/compte_succes', $data)
						. view('templates/bas_admin');
				}
			}
		}

		// L’utilisateur veut afficher le formulaire pour créer un compte
		return view('templates/haut_admin', $data)
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
		$data['page'] = "Connexion";
		$data['cfg'] = $this->model->get_configuration();
		$data['titre'] = "Se connecter";

		// L’utilisateur a validé le formulaire en cliquant sur le bouton
		if ($this->request->getMethod() == "post") {
			if (!$this->validate([
				'pseudo' => 'required',
				'mdp' => 'required'
			])) { // La validation du formulaire a échoué, retour au formulaire !
				return view('templates/haut_admin', $data)
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

				if ($statut && $statut->pro_validite == 'A') {
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
					}
				} else {
					// Rediriger vers la page de connexion avec un message flash

					$session->setFlashdata('error', 'Votre compte n\'est pas activé. Veuillez contacter le service d\'administration.');
					return view('templates/haut_admin', $data)
						. view('templates/connexion/compte_connecter');
				}
			} else {
				return view('templates/haut_admin', $data)
					. view('templates/connexion/compte_connecter');
				// . view('templates/bas_admin', $data);
			}
		}
		// L’utilisateur veut afficher le formulaire pour se connecter
		return view('templates/haut_admin', $data)
			. view('templates/connexion/compte_connecter');
		// . view('templates/bas_admin', $data);
	}

	public function afficher_profil()
	{
		$session = session();
		$data['cfg'] = $this->model->get_configuration();
		$data['page'] = "Profil";

		if ($session->has('administrateur')) {
			$compte = $session->get('administrateur');
			$data['le_message'] = "Affichage des données du profil ici !!!";
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
			return view('templates/haut_admin', $data)
				. view('templates/menu_organisateur', $data)
				. view('templates/connexion/compte_profil')
				. view('templates/bas_admin', $data);
		} else {
			return view('templates/haut_admin', $data)
				. view('templates/connexion/compte_connecter');
			// . view('templates/bas', $data);
		}
	}

	public function modifier_statut()
	{
		$data['cfg'] = $this->model->get_configuration();
		$data['titre'] = "Liste de tous les comptes";
		$data['nbTotalProfils'] = $this->model->get_count_all_profils();
		$data['logins'] = $this->model->get_all_profils();
		$data['titre'] = "Se connecter";
		
		$pro_code = $this->request->getPost('pro_code');

		if (!$pro_code) {
			return view('../errors/cli/error_404');
		}

		$session = session();

		if (!$session->has('administrateur')) {
			return view('templates/haut_admin', $data)
				. view('templates/connexion/compte_connecter');
		}

		// Récupération des informations du profil de l'administrateur connecté
		$profil = $this->model->get_profil($session->get('administrateur'));
		if (!$profil) {
			return view('../errors/cli/error_404');
		}

		// Vérification si le compte existe dans la base de données
		$compte = $this->model->get_id_profil($pro_code);
		if (!$compte) {
			return view('../errors/cli/error_404');
		}

		// Modification du statut du compte
		$nouveauStatut = ($compte->pro_validite == 'A') ? 'D' : 'A';
		$resultat = $this->model->update_statut_profil($nouveauStatut, $compte->pro_code);

		// Vérification de la réussite de la mise à jour
		if ($resultat) {
			$session->setFlashdata('message', 'Le statut du profil a été modifié avec succès !');
		} else {
			$session->setFlashdata('error', 'Une erreur s\'est produite lors de la modification du statut du profil.');
		}

		// Passage des données du profil à la vue
		$data['profil'] = $profil;

		// Affichage de la vue avec les données
		return redirect()->to(current_url());
	}


	public function deconnecter()
	{
		$data['cfg'] = $this->model->get_configuration();
		$data['page'] = "Connexion";
		$data['titre'] = "Se connecter";

		$session = session();
		$session->setFlashdata('info', 'Vous avez bien été déconnecté.');
		$session->destroy();
		return view('templates/haut_admin', $data)
			. view('templates/connexion/compte_connecter');
	}
}

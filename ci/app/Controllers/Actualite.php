<?php

namespace App\Controllers;

use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;

class Actualite extends BaseController
{
    protected $model;

    public function __construct()
    {
        helper('form');
        $this->model = model(Db_model::class);
    }

    // Liste les actualités - Repris dans Accueil.php
    public function lister()
    {
        $this->model = model(Db_model::class);
        $data['page'] = "Actualités";
        $data['cfg'] = $this->model->get_configuration();
        $data['titre'] = "Liste de tous les actualités";
        $data['news'] = $this->model->get_all_actualite();
        return view('templates/haut', $data)
            . view('templates/menu_visiteur')
            . view('templates/affichage_actualite')
            . view('templates/bas');
    }

    public function admin_lister()
    {
        $this->model = model(Db_model::class);
        $session = session();
        $data['page'] = "Gestion des actualités";
        $data['titre'] = "Se connecter";
        $data['cfg'] = $this->model->get_configuration();

        if ($session->has('administrateur')) {
            $compte = $session->get('administrateur');
            $profil = $this->model->get_profil($compte);

            // Vérifier si le profil de l'administrateur est valide
            if ($profil && $profil->pro_validite == 'A') {
                $data['profil'] = $profil;
                $data['titre'] = "Liste des actualités";
                $data['nbTotalProfils'] = $this->model->get_count_all_profils();
                $data['actus'] = $this->model->get_all_actualite();

                // Afficher la liste des profils
                return view('templates/haut_admin', $data)
                    . view('templates/menu_administrateur', $data)
                    . view('templates/affichage_admin_actualites')
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
            // Vérifier si le profil de l'administrateur est valide
            if ($profil && $profil->pro_validite == 'A') {
                $data['profil'] = $profil;
                $data['titre'] = "Liste des actualités";
                $data['nbTotalProfils'] = $this->model->get_count_all_profils();
                $data['actus'] = $this->model->get_all_actualite();

                // Afficher la liste des profils
                return view('templates/haut_admin', $data)
                    . view('templates/menu_organisateur', $data)
                    . view('templates/affichage_admin_actualites')
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
            // . view('templates/bas_admin', $data);
        }
    }

    public function afficher($numero = 0)
    {
        $this->model = model(Db_model::class);

        if ($numero == 0) {
            return redirect()->to('/');
        } else {
            $data['cfg'] = $this->model->get_configuration();
            $data['titre'] = 'Actualité n°' . $numero;
            $data['news'] = $this->model->get_actualite($numero);
            $data['page'] = 'Actualité n°' . $numero;

            return view('templates/haut', $data)
                . view('templates/menu_visiteur')
                . view('templates/affichage_actualite')
                . view('templates/bas');
        }
    }

    public function creer()
    {
        $data = [
            'l_actualite' => ''
        ];

        // L’utilisateur a validé le formulaire en cliquant sur le bouton
        if ($this->request->getMethod() == "post") {
            if (!$this->validate(
                [
                    'act_titre' => 'required|max_length[255]|min_length[2]|is_unique[t_actualite_act.act_titre]',
                    'act_texte' => 'required',
                    'act_statut' => 'required|in_list[A,D]',
                ],
                [ // Configuration des messages d’erreurs
                    'act_titre' => [
                        'required' => 'Veuillez entrer un titre pour cette actualité !',
                        'is_unique' => 'Il existe déjà une actualité avec ce titre !'
                    ],
                    'act_texte' => [
                        'required' => 'Veuillez entrer du texte pour cette actualité !',
                    ],
                    'act_statut' => [
                        'in_list' => 'Le statut de l\'actualité est invalide !',
                    ],
                ]
            )) {
                // La validation du formulaire a échoué, retour au formulaire !
                return view('templates/haut', ['titre' => 'Ajouter une actualité', 'cfg' => $this->model->get_configuration()])
                    . view('templates/actualite/actualite_creer')
                    . view('templates/bas');
            }
            // La validation du formulaire a réussi, traitement du formulaire
            $recuperation = $this->validator->getValidated();
            $this->model->set_actualite($recuperation);
            $data['l_actualite'] = $recuperation['act_titre'];

            return view('templates/haut', ['cfg' => $this->model->get_configuration()] + $data) // Utilisez l'opérateur + pour fusionner les tableaux
                . view('templates/actualite/actualite_succes')
                . view('templates/bas');
        }

        // L’utilisateur veut afficher le formulaire pour créer une actualité
        return view('templates/haut', ['titre' => 'Ajouter une actualité', 'cfg' => $this->model->get_configuration()], $data) // Utilisez l'opérateur + pour fusionner les tableaux
            . view('templates/actualite/actualite_creer')
            . view('templates/bas');
    }

    public function admin_creer()
    {
        $model = model(Db_model::class);
        $session = session();
        $data['titre'] = 'Ajouter une actualité';
        $data['page'] = 'Créer une actualité';
        $data['cfg'] = $this->model->get_configuration();

        // Vérifier si l'utilisateur est connecté en tant qu'administrateur ou organisateur
        if (!$session->has('administrateur') && !$session->has('organisateur')) {
            // Rediriger vers une page de connexion avec un message d'erreur
            $session->setFlashdata('error', 'Vous devez vous connecter pour accéder à cette page.');
            return view('templates/haut_admin', $data)
				. view('templates/connexion/compte_connecter');
        }

        // Récupére le compte de l'utilisateur connecté
        $compte = $session->get('administrateur') ?? $session->get('organisateur');

        // Récupére le profil de l'utilisateur
        $profil = $this->model->get_profil($compte);
        $data['profil'] = $profil;

        // Vérifier si le profil est valide
        if ($profil && $profil->pro_validite == 'A') {
            // L’utilisateur a validé le formulaire en cliquant sur le bouton
            if ($this->request->getMethod() == "post") {
                if (!$this->validate(
                    [
                        'act_titre' => 'required|max_length[255]|min_length[2]|is_unique[t_actualite_act.act_titre]',
                        'act_texte' => 'required',
                        'act_statut' => 'required|in_list[A,D]',
                    ],
                    [
                        'act_titre' => [
                            'required' => 'Veuillez entrer un titre pour cette actualité !',
                            'is_unique' => 'Il existe déjà une actualité avec ce titre !'
                        ],
                        'act_texte' => [
                            'required' => 'Veuillez entrer du texte pour cette actualité !',
                        ],
                        'act_statut' => [
                            'in_list' => 'Le statut de l\'actualité est invalide !',
                        ],
                    ]
                )) {
                    // La validation du formulaire a échoué, retour au formulaire !
                    return view('templates/haut_admin', $data)
                        . view('templates/menu_organisateur')
                        . view('templates/actualite/actualite_admin_creer')
                        . view('templates/bas_admin');
                }
                // La validation du formulaire a réussi, traitement du formulaire
                $recuperation = $this->validator->getValidated();
                $this->model->set_actualite($recuperation);
                $data['l_actualite'] = $recuperation['act_titre'];

                session()->setFlashdata('success', 'L\'actualité a été créée avec succès !');
                return view('templates/haut_admin', $data) // Utilisez l'opérateur + pour fusionner les tableaux
                    . view('templates/menu_organisateur')
                    . view('templates/actualite/actualite_admin_succes')
                    . view('templates/bas_admin');
            }

            // L’utilisateur veut afficher le formulaire pour créer une actualité
            return view('templates/haut_admin', $data) // Utilisez l'opérateur + pour fusionner les tableaux
                . view('templates/menu_organisateur')
                . view('templates/actualite/actualite_admin_creer')
                . view('templates/bas_admin');
        } else {
            // Rediriger vers la page de connexion avec un message flash
            $session->setFlashdata('error', 'Votre compte n\'est pas activé. Veuillez contacter le service d\'administration.');
            return view('templates/haut_admin', $data)
				. view('templates/connexion/compte_connecter');
        }
    }
}

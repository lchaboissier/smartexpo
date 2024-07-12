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
        $data['cfg'] = $this->model->get_configuration();
        $data['titre'] = "Liste de tous les actualités";
        $data['news'] = $this->model->get_all_actualite();
        return view('templates/haut', $data)
            . view('templates/menu_visiteur')
            . view('templates/affichage_actualite')
            . view('templates/bas');
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
}

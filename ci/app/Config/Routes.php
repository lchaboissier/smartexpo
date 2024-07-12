<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Accueil;
use App\Controllers\Actualite;
use App\Controllers\Admin;
use App\Controllers\Compte;
use App\Controllers\Bootstrap;
use App\Controllers\Commentaire;
use App\Controllers\Exposant;
use App\Controllers\Oeuvre;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');

// Accueil
$routes->get('/', [Accueil::class, 'afficher']);

// Admin
$routes->get('admin/afficher', [Admin::class, 'afficher']);

// Comptes
$routes->match(["get","post"],'compte/creer', [Compte::class, 'creer']);
$routes->get('compte/connecter', [Compte::class, 'connecter']);
$routes->post('compte/connecter', [Compte::class, 'connecter']);
$routes->get('compte/deconnecter', [Compte::class, 'deconnecter']);
$routes->get('compte/afficher_profil', [Compte::class, 'afficher_profil']);

$routes->get('admin/compte/lister', [Compte::class, 'lister']);
$routes->match(['get', 'post'], 'admin/compte/lister', [Compte::class, 'modifier_statut']);

// Actualites
$routes->get('accueil/afficher', [Actualite::class, 'lister']);
$routes->get('actualite/afficher', [Actualite::class, 'afficher']);
$routes->get('actualite/afficher/(:num)', [Actualite::class, 'afficher']);
$routes->match(["get","post"],'actualite/creer', [Actualite::class, 'creer']);
$routes->get('admin/actualite/lister', [Actualite::class, 'admin_lister']);
$routes->match(["get","post"], '/admin/actualite/creer', [Actualite::class, 'admin_creer']);

// Commentaires
$routes->get('livre-dor/lister', [Commentaire::class, 'lister']);
$routes->get('admin/tickets/lister', [Commentaire::class, 'admin_lister']);
$routes->match(['get', 'post'], 'admin/tickets/lister', [Commentaire::class, 'supprimer_ticket']);

// Oeuvres
$routes->get('galerie/lister', [Oeuvre::class, 'lister']);
$routes->get('galerie/afficher/(:segment)', [Oeuvre::class, 'afficher']);

// Exposants
$routes->get('exposant/afficher/(:segment)', [Exposant::class, 'afficher']);

// Bootstrap (Test)
$routes->get('bootstrap0/afficher', [Bootstrap::class, 'afficher']);

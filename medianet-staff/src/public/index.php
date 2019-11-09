<?php
session_start();

require_once('../../vendor/autoload.php');

//controllers
use medianet\controllers\ControllerDocument;
use medianet\controllers\ControllerReservation;
use medianet\controllers\ControllerEmprunt;
use medianet\controllers\ControllerUser;

//middlewares
use medianet\middlewares\FlashMiddleware;

//database connection with Eloquent
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection(parse_ini_file('../config/db.conf.ini'));
$capsule->setAsGlobal();
$capsule->bootEloquent();

//loading settings from config/settings.php
$settings = require_once "../config/settings.php";
$container = new \Slim\Container($settings);
$container["rootDir"] = __DIR__;
$app = new \Slim\App($container);

//global middlewares
$app->add(FlashMiddleware::class);

/** Routes */
//Membres
$app->group('/membre', function($app) {
    //liste des membres
    $app->get('s', ControllerUser::class.':membersList')->setName('membres');
    
    //creer un utilisateur
    $app->get('/creer', ControllerUser::class.':formAjoutUtilisateur')->setName('formUtilisateur');
    $app->post('/creer', ControllerUser::class.':addUtilisateur')->setName('addUtilisateur');
    
    //fiche détaillée d'un utilisateur
    $app->get('/{id}', ControllerUser::class.':detailsMembers')->setName('details_membre');
    
    //modification d'un utilisateur
    $app->get('/{id}/modifier', ControllerUser::class.':showUser')->setname('formUpdateUser');
    $app->post('/{id}/modifier', ControllerUser::class.':updateUser')->setName('execUpdateUser');  
    
    //supprimer un utilisateur
    $app->get('/{id}/delete', ControllerUser::class.':delete')->setName('delete');
});

//Documents
$app->group('/document', function($app) {
    //liste des documents
    $app->get('s', ControllerDocument::class.':listMedia')->setName('listdoc');
    
    //ajouter un document
    $app->get('/ajouter', ControllerDocument::class.':formAjoutDocument')->setName('formAjoutDocument');
    $app->post('/ajouter', ControllerDocument::class.':addDocument')->setName('addDocument');
    
    //fiche detaillee d un document
    $app->get('/{id}', ControllerDocument::class.':showDocument')->setName('showDocument');
    
    //modifier un document
    $app->get('/{id}/modifier', ControllerDocument::class.':formDocument')->setName('formDocument');
    $app->post('/{id}/modifier', ControllerDocument::class.':updateDocument')->setName('updateDocument');
    
    //supprimer un document
    $app->get('/{id}/supprimer', ControllerDocument::class.':delete')->setName('deleteDocument');
    
    //changer la disponibilité d un document
    $app->get('/documents/{id}/status', ControllerDocument::class.':modifStatusDocument')->setName('updateDispo');
    
});

//emprunts et retour
$app->get('/', ControllerEmprunt::class.':pageEmprunt')->setName('home');
$app->post('/take', ControllerEmprunt::class.':takeDocument')->setName('execTake');
$app->post('/return', ControllerEmprunt::class.':returnDocument')->setName('execReturn');

//Historique 
$app->get('/recap', ControllerEmprunt::class.':recapAll')->setName('watchRecap');
$app->post('/user', ControllerUSer::class.':recapUser')->setName('byUser');
$app->get('/search', ControllerDocument::class.':filter')->setName('filter');
$app->get('/reservation', ControllerReservation::class.':listeReservation')->setName('listReservation');

//demandes d'adhésions
$app->get('/adhesions', ControllerUser::class.':showAdhesions')->setName('listAdhesions');
$app->post('/adhesion/{id}', ControllerUser::class.':doAdhesion')->setName('handleAdhesions');

$app->run();

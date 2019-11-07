<?php
session_start();

require_once('../../vendor/autoload.php');

//controllers
use medianet\controllers\ControllerDocument;
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
$app = new \Slim\App($container);

//global middlewares
$app->add(FlashMiddleware::class);

/** Routes */
//affichage de la page d'accueil
//TODO nettoyer

$app->get('/membres', ControllerUser::class.':membersList')->setName('membres');
$app->get('/details/{id}', ControllerUser::class.':detailsMembers')->setName('details_membre');

$app->get('/modifier/{id}', ControllerUser::class.':showUser')->setname('formUpdateUser');
$app->post('/modifier/{id}', ControllerUser::class.':updateUser')->setName('execUpdateUser');

$app->get('/delete/{id}', ControllerUser::class.':delete')->setName('delete');
$app->get('/ajout', ControllerUser::class.':addMember')->setName('ajout_membre');
$app->post('/ajout', ControllerUser::class.':verifMember')->setName('verif_membre');


$app->get('/pwd', ControllerUser::class.':pwdPage')->setName('updatePwd');
$app->post('/pwd', ControllerUSer::class.':changePwd')->setName('lookPwd');

$app->get('/document/{id}', ControllerDocument::class.':showDocument')->setName('showDocument');
$app->get('/documents', ControllerDocument::class.':listMedia')->setName('listdoc');
$app->get('/documents/modifier/{id}', ControllerDocument::class.':edit')->setName('editDoc');
$app->post('/documents/modifier/{id}', ControllerDocument::class.':verif')->setName('verifDoc');
$app->get('/documents/supprimer/{id}', ControllerDocument::class.':delete')->setName('delete_doc');
$app->get('/ajouter/documents', ControllerDocument::class.':addDocument')->setName('add_doc');
$app->post('/documents/ajouter', ControllerDocument::class.':verifAddDocument')->setName('verif_add_doc');

//emprunts et retour
$app->get('/', ControllerEmprunt::class.':pageEmprunt')->setName('home');
$app->post('/take', ControllerEmprunt::class.':takeDocument')->setName('execTake');
$app->post('/return', ControllerEmprunt::class.':returnDocument')->setName('execReturn');

//Historique 
$app->get('/recap', ControllerEmprunt::class.':recapAll')->setName('watchRecap');
$app->post('/user', ControllerUSer::class.':recapUser')->setName('byUser');
$app->get('/search', ControllerDocument::class.':filter')->setName('filter');


$app->run();


?>


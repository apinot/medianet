<?php
session_start();

require_once('../../vendor/autoload.php');

//controllers
use medianet\controllers\ControllerDocument;
use medianet\controllers\ControllerStaff;
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
$app->get('/documents', \medianet\controllers\ControllerDocument::class.':listMedia')->setName('listdoc');

$app->get('/document/edit/{id}', \medianet\controllers\ControllerDocument::class.':edit')->setName('editDoc');
$app->post('/documents/edit/{id}', \medianet\controllers\ControllerDocument::class.':verif')->setName('verifDoc');

//emprunts et retour
$app->get('/', ControllerStaff::class.':pageEmprunt')->setName('home');
$app->post('/update', ControllerStaff::class.':which')->setName('lookEmprunt');

//Historique 
$app->get('/recap', ControllerStaff::class.':pageRecap')->setName('watchRecap');
$app->post('/user', ControllerStaff::class.':recapUser')->setName('byUser');
$app->get('/search', ControllerDocument::class.':filter')->setName('filter');


$app->run();


?>


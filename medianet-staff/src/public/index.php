<?php
require_once('../../vendor/autoload.php');

//controllers
use medianet\controllers\ControllerStaff;
use medianet\controllers\ControllerUser;

//database connection with Eloquent
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection(parse_ini_file('../config/db.conf.ini'));
$capsule->setAsGlobal();
$capsule->bootEloquent();

//loading settings from config/settings.php
$settings = require_once "../config/settings.php";
$container = new \Slim\Container($settings);
$app = new \Slim\App($container);

/** Routes */
//affichage de la page d'accueil
$app->get('/', ControllerStaff::class.':accueil')->setName('home');

$app->get('/membres', ControllerUser::class.':membersList')->setName('membres');
$app->get('/details/{id}', ControllerUser::class.':detailsMembers')->setName('details_membre');

$app->get('/modifier/{id}', ControllerUser::class.':showUser')->setname('formUpdateUser');
$app->post('/modifier/{id}', ControllerUser::class.':updateUser')->setName('execUpdateUser');

$app->get('/delete/{id}', ControllerUser::class.':delete')->setName('delete');

$app->get('/pwd', ControllerUser::class.':pwdPage')->setName('updatePwd');
$app->post('/pwd', ControllerUSer::class.':changePwd')->setName('lookPwd');
$app->get('/document/{id}', ControllerDocument::class.':showDocument')->setName('showDocument');

//emprunts et retour
$app->get('/emprunt', ControllerStaff::class.':pageEmprunt')->setName('emprunter');
$app->post('/emprunt', ControllerStaff::class.':which')->setName('lookEmprunt');

//Historique 
$app->get('/recap', ControllerStaff::class.':pageRecap')->setName('watchRecap');
$app->post('/user', ControllerStaff::class.':recapUser')->setName('byUser');


$app->run();


?>


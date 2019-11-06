<?php
session_start();

require_once('../../vendor/autoload.php');

//controllers
use medianet\controllers\ControllerStaff;

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

//emprunts et retour
$app->get('/emprunt', ControllerStaff::class.':pageEmprunt')->setName('emprunter');
$app->post('/emprunt', ControllerStaff::class.':which')->setName('lookEmprunt');

//Historique 
$app->get('/recap', ControllerStaff::class.':pageRecap')->setName('watchRecap');
$app->post('/user', ControllerStaff::class.':recapUser')->setName('byUser');


$app->run();


?>


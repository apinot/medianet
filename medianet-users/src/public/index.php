<?php
session_start();

require_once('../../vendor/autoload.php');

//controllers
use medianet\controllers\ControllerHome;
use medianet\controllers\ControllerUser;

//middlewares
use oxanaplay\middlewares\MiddlewareFlash;


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
//$app->add(MiddlewareFlash::class);

/** Routes */
//affichage de la page d'accueil


$app->get('/', ControllerHome::class.':index')->setName('home');

$app->get('/connexion', ControllerUser::class.':afficherFomulaireConnexion')->setName('formConnexion');
$app->post('/connexion', ControllerUser::class.':connecter')->setName('execConnexion');
$app->get('/deconnexion', ControllerUser::class.':deconnecter')->setName('execDeconnexion');

$app->get('/compte', ControllerUser::class.':afficherProfil')->setName('showProfil');

$app->get('/modifier', ControllerUser::class.':showUser')->setname('formUpdateUser');
$app->post('/modifier', ControllerUser::class.':updateUser')->setName('execUpdateUser');

$app->run();
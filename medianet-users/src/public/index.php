<?php
session_start();

require_once('../../vendor/autoload.php');

//controllers
use medianet\controllers\ControllerHome;
use medianet\controllers\ControllerUser;
use medianet\controllers\ControllerDocument;

//middlewares
use medianet\middlewares\FlashMiddleware;
use medianet\middlewares\AuthMiddleware;

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

$app->get('/', \medianet\controllers\IndexUserController::class.':listMedia')->setName('home');
$app->post('/filter', \medianet\controllers\MediaController::class.':filter')->setName('filter');


$app->get('/connexion', ControllerUser::class.':afficherFomulaireConnexion')->setName('formConnexion');
$app->post('/connexion', ControllerUser::class.':connecter')->setName('execConnexion');
$app->get('/deconnexion', ControllerUser::class.':deconnecter')->setName('execDeconnexion');

$app->get('/compte', ControllerUser::class.':afficherProfil')->setName('showProfil');
$app->get('/pwd', ControllerUser::class.':pwdPage')->setName('updatePwd');
$app->post('/pwd', ControllerUSer::class.':changePwd')->setName('lookPwd');

$app->get('/modifier', ControllerUser::class.':showUser')->setname('formUpdateUser');
$app->post('/modifier', ControllerUser::class.':updateUser')->setName('execUpdateUser');

$app->get('/document/{id}', ControllerDocument::class.':showDocument')->setName('showDocument');

$app->run();



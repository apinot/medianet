<?php
require_once('../../vendor/autoload.php');

//controllers
use medianet\controllers\ControllerHome;
//use medianet\controllers\ControllerUser;

//database connection with Eloquent
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection(parse_ini_file('../config/db.conf.ini'));
$capsule->setAsGlobal();
$capsule->bootEloquent();

//loading settings from config/settings.php
$settings = require_once "../config/settings.php";
$container = new \Slim\Container($settings);
$app = new \Slim\App($container);


$app->get('/', \medianet\controllers\IndexUserController::class.':listMedia')->setName('acceuil');


//$app->get('/connexion', UserController::class.':afficherFomulaireConnexion')->setName('formConnexion');
//$app->get('/connexion', ControllerUser::class.':afficherFomulaireConnexion')->setName('formConnexion');
//$app->post('/connexion', ControllerUser::class.':connecter')->setName('execConnexion');
//$app->get('/', ControllerHome::class.':index')->setName('home');

//$app->get('/connexion', UserController::class.':afficherFomulaireConnexion')->setName('formConnexion');
//$app->post('/connexion', ControllerUser::class.':connecter')->setName('execConnexion');

$app->run();
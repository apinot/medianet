<?php
require_once('../../vendor/autoload.php');

//controllers
use medianet\controllers\ControllerStaff;

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

$app->get('/emprunt', ControllerStaff::class.':pageEmprunt')->setName('emprunter');
$app->post('/emprunt', ControllerStaff::class.':checkEmprunt')->setName('lookEmprunt');

$app->run();

?>


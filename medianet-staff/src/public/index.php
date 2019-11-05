<?php
session_start();

require_once('../../vendor/autoload.php');

//controllers
use medianet\controllers\ControllerHome;
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
//$app->get('/', ControllerHome::class.':index')->setName('home');
$app->get('/', function(Request $request, Response $response){
	return $response;getBody().write('r'); 
});
$app->run();
?>


<?php
require_once('../../vendor/autoload.php');

//database connection with Eloquent
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection(parse_ini_file('../config/db.conf.ini'));
$capsule->setAsGlobal();
$capsule->bootEloquent();

//loading settings from config/settings.php
$settings = require_once "../config/settings.php";
$container = new Slim\Container($settings);
$app = new \Slim\App($container);

/** Routes */
//affichage de la page d'accueil
$app->get('/', function($request, $response, $args) {
    $response->getBody()->write('Hello World');
    return $response;
})->setName('home');

$app->run();
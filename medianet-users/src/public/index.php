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

/** Routes */
//affichage de la page d'accueil
<<<<<<< HEAD
=======

//Installation de twig
$container['view'] = function($container) {
    $view = new \Slim\Views\Twig('../views', []);
    //Instantiate and add Slim specific extension
    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

    return $view;
};

>>>>>>> 792515d4176d023dfb8b6afc52ee12795944a55c

$app->get('/', \medianet\controllers\IndexUserController::class.':listMedia')->setName('acceuil');
<<<<<<< HEAD


//$app->get('/connexion', UserController::class.':afficherFomulaireConnexion')->setName('formConnexion');
//$app->get('/connexion', ControllerUser::class.':afficherFomulaireConnexion')->setName('formConnexion');
//$app->post('/connexion', ControllerUser::class.':connecter')->setName('execConnexion');
=======
$app->get('/', ControllerHome::class.':index')->setName('home');

$app->get('/connexion', UserController::class.':afficherFomulaireConnexion')->setName('formConnexion');
$app->post('/connexion', ControllerUser::class.':connecter')->setName('execConnexion');
>>>>>>> 792515d4176d023dfb8b6afc52ee12795944a55c

$app->run();
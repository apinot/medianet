<?php
session_start();

require_once('../../vendor/autoload.php');

//controllers
use medianet\controllers\ControllerUser;
use medianet\controllers\ControllerDocument;
use medianet\controllers\ControllerReservation;

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
$container["rootDir"] = __DIR__;
$app = new \Slim\App($container);

//global middlewares
$app->add(FlashMiddleware::class);

/** Routes */

//affichage de la page d'accueil
$app->get('/', ControllerDocument::class.':listMedia')->setName('home');


//Connexions et déconnexions
$app->get('/connexion', ControllerUser::class.':afficherFomulaireConnexion')->setName('formConnexion');
$app->post('/connexion', ControllerUser::class.':connecter')->setName('execConnexion');
$app->get('/deconnexion', ControllerUser::class.':deconnecter')->setName('execDeconnexion');

//Profil
$app->group('/compte', function($app) {
    $app->get('/profil', ControllerUser::class.':afficherProfil')->setName('showProfil')->add(AuthMiddleware::class);
    $app->get('/password', ControllerUser::class.':afficherFormulaireChangeMdp')->setName('formPassword');
    $app->post('/password', ControllerUSer::class.':updatePassword')->setName('updatePassword');
    //Modifier informations utilisateur
    $app->get('/modifier', ControllerUser::class.':showUser')->setname('formUpdateUser');
    $app->post('/modifier', ControllerUser::class.':updateUser')->setName('execUpdateUser');
});

//Documents
$app->group('/document', function($app) {
    $app->get('/search', ControllerDocument::class.':filter')->setName('filter');
    $app->get('/{id}', ControllerDocument::class.':showDocument')->setName('showDocument');
    $app->get('/{id}/reserver', ControllerReservation::class.':reserver')->setName('reserver')->add(AuthMiddleware::class);
   
});

//Adhesion utilisateur
$app->get('/adhesion', ControllerUser::class.':formAdhesion')->setname('formAdhesion');
$app->post('/adhesion', ControllerUser::class.':adhesion')->setname('sendAdhesion');

$app->run();



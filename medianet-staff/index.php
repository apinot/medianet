<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Slim\App;
use Slim\Http\Response as SlimResponse;
require 'vendor/autoload.php';

$container["view"]=function($container){
    $views=new \Slim\Views\Twig('/views',[]);
    $router=$container->get('router');
    $uri=\Slim\Http\Uri::createFromEnvironment(new Slim\Http\Environment($_SERVER));
    $views->addExtension(new Slim\Views\TwigExtension($router,$uri));
    return $views;
};

$app = new App($container);
$app->get('/', "src\\controller\\Accueil:Index");
$app->run();

?>

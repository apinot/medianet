<?php

use Slim\Http\Environment;
use Slim\Http\Uri;
use \Slim\Views\Twig;

use medianet\controllers\Auth;
use Slim\Views\TwigExtension;

return [
    'view' => function ($c) {
        $view = new Twig('../views', [
            'debug' => true
        ]);
            
            // Instantiate and add Slim specific extension
            $router = $c->get('router');
            $uri = Uri::createFromEnvironment(new Environment($_SERVER));
            $view->addExtension(new TwigExtension($router, $uri));

            //fonction person
            $view->getEnvironment()->addFunction(new Twig_Function("est_connecte", Auth::class."::estConnecte"));
            $view->getEnvironment()->addFunction(new Twig_Function("auth_user", Auth::class."::getUser"));

            //flashmessages
            $view->getEnvironment()->addFunction(new Twig_Function("get_data", Flash::class."::get"));
            $view->getEnvironment()->addTest(new Twig_Test("flashed", Flash::class."::has"));

            return $view;
    },
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
<?php

use Slim\Http\Environment;
use Slim\Http\Uri;
use \Slim\Views\Twig;
<<<<<<< HEAD
use Slim\Views\TwigExtension;

=======
use \Slim\Http\Uri;
use \Slim\Http\Environment;
use \Slim\Views\TwigExtension;

use medianet\controleurs\Auth;
>>>>>>> 51c38e42f08ffb7cfcecb36d782785aa9c0adbfe

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
            $view->getEnvironment()->addFunction(new Twig_Function("get_user_id", Auth::class."::estConnecte"));

            return $view;
    },
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
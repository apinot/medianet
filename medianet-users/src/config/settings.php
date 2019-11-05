<?php

use \Slim\Views\Twig;
use \Slim\Http\Uri;
use \Slim\Http\Environment;
use \Slim\Views\TwigExtension;

return [
    'view' => function ($c) {
        $view = new Twig('../views', [
            'debug' => true
            ]);
            
            // Instantiate and add Slim specific extension
            $router = $c->get('router');
            $uri = Uri::createFromEnvironment(new Environment($_SERVER));
            $view->addExtension(new TwigExtension($router, $uri));

            return $view;
        },
        'settings' => [
            'displayErrorDetails' => true,
        ],
    ];
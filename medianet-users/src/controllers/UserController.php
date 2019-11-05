<?php

namespace medianet\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;


class UserController extends Controller {

    public function afficherFomulaireConnexion(Request $request, Response $response, $args) {
        return $this->views->render($response, 'login.html.twig');
    }
}
<?php

namespace medianet\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;


class ControllerStaff extends Controller {

    public function accueil(Request $request, Response $response, $args) {
        return $this->render($response, 'base.html.twig');
    }

    public function pageEmprunt(Request $request, Response $response, $args) {
        return $this->render($response, 'emprunt.html.twig');
    }
    
    public function checkEmprunt(Request $request, Response $response, $args) {
	$reference = Utils::getFilteredPost($request, 'reference');
	$idAdherent = Utils::getFilteredPost($request, 'idAdherent');
	if(($reference == null)||($idAdherent)){
		echo 'champs vide';
	}
        //return Utils::redirect($response, 'base.html.twig');
    }

}


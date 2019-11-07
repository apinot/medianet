<?php

namespace medianet\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use medianet\models\User;
use medianet\models\Document;
use medianet\models\Emprunt;

//TODO nettoyer cette classe
class ControllerStaff extends Controller {

	//montre toutes les demandes d'adhésions
	public function showAdhesions(Request $request, Response $response){
		$users = User::all();
		$this->render($response, 'adhesions.html.twig', ['users' => $users]);
	}

	public function doAdhesion(Request $request, Response $response){
		return Utils::redirect($response, "listAdhesions");
	}	
}

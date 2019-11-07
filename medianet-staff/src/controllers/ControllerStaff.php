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
	
	//page récapitulative des emprunts
	public function pageRecap(Request $request, Response $response, $args) {
		$emprunts = Emprunt::all();
		$this->render($response, 'recap.html.twig', ['emprunts' => $emprunts]);
	}
	
	//permet d'entrer un id d'un utilisateur 
	public function recapUser(Request $request, Response $response, $args){
		$idUser = Utils::getFilteredPost($request, 'idUser');
		$emprunts = Emprunt::where("user_id" ,"=", $idUser)->get();
		$this->render($response, 'recap.html.twig', ['emprunts' => $emprunts]);
	}

	//montre toutes les demandes d'adhésions
	public function showAdhesions(Request $request, Response $response){
		$users = User::all();
		$this->render($response, 'adhesions.html.twig', ['users' => $users]);
	}
	
}

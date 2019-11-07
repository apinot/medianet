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
	
	//Renvoie vers l'accueil	
	public function accueil(Request $request, Response $response, $args) {
		return $this->render($response, 'base.html.twig');
	}
	
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
	
	//montre les emprunts
	public function showData(Response $response, $emprunts){
		foreach($emprunts as $emprunt){
			echo "Référence: ".$emprunt->document_id.
			" adhérent n°".$emprunt->user_id.
			" date d'emprunt: ".$emprunt->date_emprunt.
			" date limite: ".$emprunt->date_emprunt.
			" date de retour: ".$emprunt->date_emprunt.
			"<br>";
		}
		return $this->render($response, 'recap.html.twig');
	}
}
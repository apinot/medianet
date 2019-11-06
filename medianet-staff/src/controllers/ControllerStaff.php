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
	
	//page d'emprunt
	public function pageEmprunt(Request $request, Response $response, $args) {
		return $this->render($response, 'accueil.html.twig');
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
	
	public function takeDocument(Request $request, Response $response, $args) { 
		$userId = Utils::getFilteredPost($request, "user");
		if($userId === null || $userId === "") {
			Flash::flashInfo('Veuillez rensigner un numéro d\'adhérant');
			return Utils::redirect($response, "home");
		}
		
		$user = User::find($userId);
		if($user == null){
			Flash::flashError('L\'utilisateur n\'existe pas !');
			return Utils::redirect($response, "home");
		}
		
		$documentsId = Utils::getFilteredPost($request, 'documents');
		$documents = [];
		$hasIgnored = false;
		foreach($documentsId as $idDoc) {
			if($idDoc == "") continue;
			$doc = Document::find($idDoc);
			if($doc == null ) continue;
			if(!$doc->disponible){
				$hasIgnored = true;
				continue;
			}
			$documents[] = $doc;
		}
		
		$docCount = count($documents);
		if($docCount <= 0) {
			Flash::flashError('Les documents n\'existent pas ou ne sont pas disponibles');
			return Utils::redirect($response, "home");
		}
		
		$dateEmprunt = time();
		$dateLimit = $dateEmprunt += 3600 * 24 * 14;
		
		foreach($documents as $document) {
			$emprunt = new Emprunt();
			$emprunt->date_emprunt = date('Y-m-d H:i:s', $dateEmprunt);
			$emprunt->date_limite = date('Y-m-d H:i:s', $dateLimit);
			$emprunt->user_id = $userId;
			$emprunt->document_id = $document->id;
			$emprunt->save();
			
			$document->disponible = false;
			$document->save();
		}
		
		//TODO afficher un recap de l'emprunt actuel
		Flash::flashSuccess($docCount.' documents ont été empruntés.');
		if($hasIgnored) {
			Flash::flashInfo("Certains documents ont été ignorés car ils n'existent pas ou ne sont pas disponibles !");
		}
		return Utils::redirect($response, 'home');
	}	
}
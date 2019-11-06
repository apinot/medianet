<?php

namespace medianet\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use medianet\models\User;
use medianet\models\Document;
use medianet\models\Emprunt;


class ControllerStaff extends Controller {

	//Renvoie vers l'accueil	
	public function accueil(Request $request, Response $response, $args) {
		return $this->render($response, 'base.html.twig');
	}

	//page d'emprunt
	public function pageEmprunt(Request $request, Response $response, $args) {
		return $this->render($response, 'emprunt.html.twig');
	}

	//page récapitulative des emprunts
	public function pageRecap(Request $request, Response $response, $args) {
		$emprunts = Emprunt::all();
		$this->showData($response, $emprunts);
	}

	//permet d'entrer un id d'un utilisateur 
	public function recapUser(Request $request, Response $response, $args){
		$idUser = Utils::getFilteredPost($request, 'idUser');
		$emprunts = Emprunt::where("user_id" ,"=", $idUser)->get();
		$this->showData($response, $emprunts);
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


	//check les champs
	public function which(Request $request, Response $response, $args) {    
		//fuseau horaire 
		$timezone = date_default_timezone_set('France');
		$btn = $_POST['btn'];   
		$reference = Utils::getFilteredPost($request, 'reference');
		$idAdherent = Utils::getFilteredPost($request, 'idAdherent');
		if(($reference == null)||($idAdherent == null)){
			echo 'champs vide';
		}
		//vérifie si la référence et l'adhérent existent
		$adherent = User::find($idAdherent);
		$media = Document::find($reference);
		$ok = 0;
		if($adherent == null){
			echo "cet adhérent n'existe pas";
		}elseif($media == null){
			echo "ce média n'existe pas";
		}else{
			if ($btn == "Emprunter"){
				$ok = $this->emprunt($media, $reference, $idAdherent);
			}elseif($btn == "Retourner"){
				$ok = $this->retour($media, $idAdherent);
			}
		}
		if($ok == 1){return Utils::redirect($response, 'home');}
    	}

	//Gère le retour
	public function retour($media, $idAdherent){
		$emprunt = Emprunt::where("document_id", "=", $media->id)->first();
		if($emprunt == null){
			echo "ce média n'a pas été emprunté";
		}elseif($emprunt->user_id != $idAdherent){
			echo "cet usager n'a pas réservé ce média";
		}else{
			$emprunt->delete();
			$media->disponible = 1;
			$media->save();
			return 1;
		}
	}

	//gère l'emprunt
	public function emprunt($media, $reference, $idAdherent){
		//check la disponibilité du média
		if(($media->disponible) == 0){
			echo "ce média n'est pas dispo";
		}else{	
			//insertion du nouvel emprunt dans la bdd
			$emprunt = new Emprunt;
			$emprunt->document_id = $reference;
			$emprunt->user_id = $idAdherent;
			$emprunt->date_emprunt = date('Y/d/m h:i:s',time());
			$emprunt->date_limite = date('Y/d/m h:i:s',time());
			$emprunt->date_retour = date('Y/d/m h:i:s',time());
			$emprunt->save();
			//changement de la disponibilité du média
			$media->disponible = 0;
			$media->save();
			return 1;
		}
	}
}


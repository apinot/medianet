<?php

namespace medianet\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use medianet\models\User;
use medianet\models\Document;
use medianet\models\Emprunt;


class ControllerStaff extends Controller {
	
	public function accueil(Request $request, Response $response, $args) {
		return $this->render($response, 'base.html.twig');
	}

	public function pageEmprunt(Request $request, Response $response, $args) {
		return $this->render($response, 'emprunt.html.twig');
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
		if($adherent == null){
			echo "cet adhérent n'existe pas";
		}elseif($media == null){
			echo "ce média n'existe pas";
		}else{
			if ($btn == "Emprunter"){
				$this->emprunt($response, $media, $reference, $idAdherent);
			}elseif($btn == "Retourner"){
				$this->retour($response, $media);
			}
		}
    	}

	//Gère le retour
	public function retour($response, $media){
		if(($media->disponible) == 1){
			echo "ce média n'a pas été emprunté";
		}else{
			$emprunt = Emprunt::where("document_id", "=", $media->id);
			$emprunt->delete();
			$media->disponible = 1;
			$media->save();
			return Utils::redirect($response, 'home');
		}
		//vérifie si la référence et l'adhérent existent
		$adherent = User::find($idAdherent)->first();
		$media = Document::where('reference',$reference)->first();
		if($adherent == null){
			echo "cet adhérent n'existe pas";
		}elseif($media == null){
			echo "ce média n'existe pas";
		//check la disponibilité du média
		}elseif(($media->disponible) == 1){
			echo "ce média n'est pas disponible";
		}else{
			//insertion du nouvel emprunt dans la bdd
			$emprunt = new Emprunt();
			$emprunt->document_id = $reference;
			$emprunt->user_id = $idAdherent;
			$emprunt->date_emprunt = date('Y/d/m h:i:s',time());
			$emprunt->date_limite = date('Y/d/m h:i:s',time());
			$emprunt->date_retour = date('Y/d/m h:i:s',time());
			$emprunt->save();
			//changement de la disponibilité du média
			$media->disponible = 1;
			$media->save();
			return Utils::redirect($response, 'home');
	}
}

	//gère l'emprunt
	public function emprunt($response, $media, $reference, $idAdherent){
		//check la disponibilité du média
		if(($media->disponible) == 0){
			echo "ce média n'est pas dispo";
		}else{	
			//insertion du nouvel emprunt dans la bdd
			$emprunt = new Emprunt;
			$emprunt->document_id = $reference;
			$emprunt->id_user = $idAdherent;
			$emprunt->date_emprunt = date('Y/d/m h:i:s',time());
			$emprunt->date_limite = date('Y/d/m h:i:s',time());
			$emprunt->date_retour = date('Y/d/m h:i:s',time());
			$emprunt->save();
			//changement de la disponibilité du média
			$media->disponible = 0;
			$media->save();
			return Utils::redirect($response, 'home');
		}
	}
}


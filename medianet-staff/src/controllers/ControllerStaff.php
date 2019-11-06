<?php

namespace medianet\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use medianet\models\User;
use medianet\models\Document;


class ControllerStaff extends Controller {

    public function accueil(Request $request, Response $response, $args) {
        return $this->render($response, 'base.html.twig');
    }

    public function pageEmprunt(Request $request, Response $response, $args) {
        return $this->render($response, 'emprunt.html.twig');
    }
    
    public function checkEmprunt(Request $request, Response $response, $args) {    
	$timezone = date_default_timezone_set('France');
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
	}
	elseif($media == null){
		echo "ce média n'existe pas";
	}
	else{
		//insertion du nouvel emprunt dans la bdd
		$emprunt = new Emprunt;
		$emprunt->document_id = $reference;
		$emprunt->user_id = $idAdherent;
		$emprunt->date_emprunt = date('m/d/Y',timezone());
		$emprunt->date_limite = date('m/d/Y',timezone());
		$emprunt->date_retour = date('m/d/Y',timezone());
		$emprunt->save();
        	return Utils::redirect($response, 'home');
	}
    }

}


<?php

namespace medianet\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use medianet\models\User;
use medianet\models\Emprunt;

//TODO nettoyer cette classe
class ControllerStaff extends Controller {

	//montre toutes les demandes d'adhésions
	public function showAdhesions(Request $request, Response $response){
		$users = User::all();
		$this->render($response, 'adhesions.html.twig', ['users' => $users]);
	}

	//gère l'acceptation ou non d'une demande d'adhésion
	public function doAdhesion(Request $request, Response $response, $args){
		$idUser = Utils::sanitize($args['id']);
		$adherent = User::find($idUser);
		if(isset($_POST['valider'])){
			$adherent->demande_adhesion = null;
			$adherent->adhesion = date('Y-m-d H:i:s');
		}elseif(isset($_POST['refuser'])){
			$adherent->delete();
		}
		$adherent->save();
		return Utils::redirect($response, "listAdhesions");
	}	
}

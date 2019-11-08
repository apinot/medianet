<?php
namespace medianet\controllers;

use \medianet\models\User;
use \medianet\models\Emprunt;
use \medianet\models\Document;

class ControllerEmprunt extends Controller {

    /**
     * Affiche le formulaire d'emprunt et de retour
     */
	public function pageEmprunt($request, $response, $args) {
		return $this->render($response, 'accueil.html.twig');
    }
    
    /**
     * Méthode pour emprunter des documents
     */
	public function takeDocument($request, $response, $args) { 
		$userId = Utils::getFilteredPost($request, "user");
		if($userId === null || $userId === "") {
			Flash::flashInfo("Veuillez rensigner un numéro d\'adhérant");
			return Utils::redirect($response, "home");
		}
		
		$user = User::find($userId);
		if($user == null){
			Flash::flashError("L'utilisateur n'existe pas !");
			return Utils::redirect($response, "home");
		}
		//vérifie que l'utilisateur est un adhérent
		if($user->adhesion == null){
			Flash::flashError("l'adhérent n'existe pas");
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
			Flash::flashError("Les documents n'existent pas ou ne sont pas disponibles");
			return Utils::redirect($response, "home");
		}
		
		$dateEmprunt = time();
		$dateLimit = $dateEmprunt + 3600 * 24 * 14;
		
		foreach($documents as $document) {
			$emprunt = new Emprunt();
			$emprunt->date_emprunt = date("Y-m-d H:i:s", $dateEmprunt);
			$emprunt->date_limite = date("Y-m-d H:i:s", $dateLimit);
			$emprunt->user_id = $userId;
			$emprunt->document_id = $document->id;
			$emprunt->save();
			
			$document->disponible = false;
			$document->save();
		}
		
		if($hasIgnored) {
			Flash::flashInfo("Certains documents ont été ignorés car ils n'existent pas ou ne sont pas disponibles !");
		}
		return $this->render($response, "finEmprunts.html.twig", ['user' =>$user, 'documents' => $documents]);
	}	

    /**
     * Méthode pour rendre des documents
     */
	public function returnDocument($request, $response, $args) {
		$documentsId = Utils::getFilteredPost($request, "documents");

		$documents = [];
		foreach($documentsId as $idDoc) {
			if($idDoc == "") continue;
			$doc = Document::find($idDoc);
			if($doc == null || $doc->disponible) continue;
			$documents[] = $doc;
		}

		$docCount = count($documents);
		if($docCount <= 0) {
			Flash::flashError("Les documents n'existent pas ou ne sont pas empruntés");
			return Utils::redirect($response, "home");
		}

		$dateRetour = time();

		$user = null;

		foreach($documents as $document) {
			$emprunt = $document->emprunts()->whereNull('date_retour')->first();
			if($emprunt === null) {
				continue;
			}

			$emprunt->date_retour = date('Y-m-d H:i:s', $dateRetour);
			$emprunt->save();
			$user = $emprunt->user;
			
			$document->disponible = true;
			$document->save();
		}

		$possession = $user->emprunts()->whereNull('date_retour')->get();

		return $this->render($response, 'finRendu.html.twig', ['user' => $user, 'documents' => $documents, 'empruntsRestant' => $possession]);
	}

		//page récapitulative des emprunts
		public function recapAll($request, $response, $args) {
			$emprunts = Emprunt::all();
			$this->render($response, 'recap.html.twig', ['emprunts' => $emprunts]);
		}
		
}

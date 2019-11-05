<?php

namespace medianet\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;


class ControllerUser extends Controller {

    public function afficherFomulaireConnexion(Request $request, Response $response, $args) {
        return $this->render($response, 'login.html.twig');
    }

    /**
     * execute la connexion
     */
    public function connecter(Request $request, Response $response, $args){
        $email = Utils::getFilteredPost($request,'email');
        $pwd = Utils::getFilteredPost($request, 'password');
        if(!Auth::connexion($email,$pwd)){
            Flash::flashError('email ou mot de passe incorrecte');
            return Utils::redirect($response, 'formConnexion');
        }
        Flash::flashSuccess('Vous êtes connecté en tant que '.$email);
        return Utils::redirect($response, 'home');
    }


    public function deconnecter(Request $request, Response $response){
        Auth::deconnexion(); 
        return Utils::redirect($response, 'home');
    }


    /**
     * fenetre d'edition User
     */
    public function afficherProfil(Request $request, Response $response) {
        $user = Auth::getUser();
        return $this->render($response, 'profil.html.twig', compact("user"));
    }

    //changement du mot de passe
    public function pwdPage(Request $request, Response $response) {
	    return $this->render($response, 'changeMdp.html.twig', compact("user"));
    }

    //checks for a new user password
    public function changePwd(Request $request, Response $response){
		$user = Auth::getUser();
	    	$mdpUser = $user->mdp;
		$old = Utils::getFilteredPost($request, 'oldMdp');
		$new = Utils::getFilteredPost($request, 'newMdp');
		$confirm = Utils::getFilteredPost($request, 'confirmMdp');

		//Check the passwords entered
		if(($old == null)||($new == null)||($confirm == null)){
			echo 'emptys';
		}else if(password_verify($old, $mdpUser)==false){
			echo 'old bad';
		}else if($new != $confirm){
			echo 'no same';
		}else{
			$toInsert = password_hash($new, PASSWORD_DEFAULT);
			$user->mdp = $toInsert;
			$user->save();
		 	return Utils::redirect($response, 'showProfil');
		}
    }

    //gestion d'un emprunt
    public function empruntPage(Request $request, Response $response){
	return $this->render($response, 'emprunt.html.twig');
    }


    //gestion d'un emprunt
    public function emprunt(Request $request, Response $response){
	
    }
    /**
    * 
    */
    public function showUser(Request $request, Response $response, $args) {
        $user = Auth::getUser();
        return $this->render($response, 'editProfil.html.twig',['user'=>$user]);
    }

    public function updateUser(Request $request, Response $response, $args) {
        $user = Auth::getUser();

        $user->nom = Utils::getFilteredPost($request, "nom");
        $user->prenom = Utils::getFilteredPost($request, "prenom");
        $user->adresse = Utils::getFilteredPost($request, "adresse");
        $user->email = filter_var(Utils::getFilteredPost($request, "email"), FILTER_VALIDATE_EMAIL);
        $user->telephone = Utils::getFilteredPost($request, "telephone");

        $user->save();
        return Utils::redirect($response, 'showProfil');
    }
}

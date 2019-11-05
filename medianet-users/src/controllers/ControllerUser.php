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
        Flash::flashSuccess('Vous êtes connecté');
        return Utils::redirect($response, 'home');
    }


    public function deconnecter(Request $request, Response $response){
        Auth::deconnexion(); 
        Flash::flashSuccess('Vous vous êtes deconnecté');
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
            Flash::flashError("Des données sont manquantes");
            return Utils::redirect($response, "updatePwd");
        }
        if ($new !== $confirm) {
            Flash::flashError("Le mot de passe et sa confirmation ne correspondent pas");
            return Utils::redirect($response, "updatePwd");
        }
        if (!Auth::modifierMdp($old, $new)) {
            Flash::flashError("L'ancien mot de passe ne correspond pas");
            return Utils::redirect($response, "updatePwd");
        }
        Flash::flashSuccess("Le mot de passe a été changé");
        return Utils::redirect($response, "showProfil");
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

<?php

namespace medianet\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use medianet\models\User;

class ControllerUser extends Controller {

    public function afficherFomulaireConnexion(Request $request, Response $response, $args) {
        return $this->render($response, 'login.html.twig');
    }

    public function connecter(Request $request, Response $response, $args){
        $email = Utils::getFilteredPost($request,'email');
        $pwd = Utils::getFilteredPost($request, 'password');
        if(!Auth::connexion($email,$pwd)){
            Flash::flashError('email ou mot de passe incorrecte');
            return Utils::redirect($response, 'formConnexion');
        }
        $user = User::where('email','=',$email)->first();
        if($user->adhesion === null){
            Flash::flashError("Votre compte n'a pas été validé");
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

    public function afficherProfil(Request $request, Response $response) {
        $user = Auth::getUser();
        return $this->render($response, 'profil.html.twig', compact("user"));
    }

    //changement du mot de passe
    public function afficherFormulaireChangeMdp(Request $request, Response $response) {
	    return $this->render($response, 'changeMdp.html.twig', compact("user"));
    }

    //checks for a new user password
    public function updatePassword(Request $request, Response $response){
		$user = Auth::getUser();
		$old = Utils::getFilteredPost($request, 'oldMdp');
		$new = Utils::getFilteredPost($request, 'newMdp');
		$confirm = Utils::getFilteredPost($request, 'confirmMdp');

		//Check the passwords entered
		if(($old == null)||($new == null)||($confirm == null)){
            Flash::flashError("Des données sont manquantes");
            return Utils::redirect($response, "formPassword");
        }
        if ($new !== $confirm) {
            Flash::flashError("Le mot de passe et sa confirmation ne correspondent pas");
            return Utils::redirect($response, "formPassword");
        }
        if (!Auth::modifierMdp($old, $new)) {
            Flash::flashError("L'ancien mot de passe ne correspond pas");
            return Utils::redirect($response, "formPassword");
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

	public function formAdhesion(Request $request, Response $response){
		return $this->render($response, 'adhesion.html.twig');
	}

    public function adhesion(Request $request, Response $response) {
        $email = Utils::getfilteredPost($request, 'email');
        if(!Auth::verifEmail($email)) {
            Flash::flashError("L'email est déjà utilisé");
            return Utils::redirect($response, "adhesionUser");
        }
        $newMdp = Utils::getfilteredPost($request, 'mdp');
        $confMdp = Utils::getfilteredPost($request, 'mdpConf');
        if ($newMdp !== $confMdp) {
            Flash::flashError("Les mots de passes ne sont pas identique");
            return Utils::redirect($response, "adhesionUser");
        }
		$newUser = new User();
		$newUser->nom = Utils::getfilteredPost($request, 'nom');
		$newUser->prenom = Utils::getfilteredPost($request, 'prenom');
        $newUser->mdp = password_hash($newMdp, PASSWORD_DEFAULT);
        $newUser->email = $email;		
		$newUser->adresse = Utils::getfilteredPost($request, 'adresse');
		$newUser->telephone = Utils::getfilteredPost($request, 'telephone');
		$newUser->demande_adhesion = date('Y-m-d H:i:s');
        $newUser->save();
        Flash::flashSuccess("Votre demande d'inscription a bien été envoyé");
		return Utils::redirect($response, 'home');
	}
}

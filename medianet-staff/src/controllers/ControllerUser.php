<?php

namespace medianet\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use medianet\models\User;
use medianet\models\Document;
use medianet\models\Emprunt;


class ControllerUser extends Controller {

    public function membersList(Request $request, Response $response){
        $users = User::all();
		return $this->render($response, 'membres_liste.html.twig',['users'=>$users]);
    }
    public function afficherProfil(Request $request, Response $response,$args) {
        $id = Utils::sanitize($args['id']);
        return $this->render($response, 'profil.html.twig', compact("user"));
    }


    public function delete(Request $request, Response $response,$args){
        $id = Utils::sanitize($args['id']);
        $user = User::find(intval($id));
        $user->delete();
		return Utils::redirect($response,'membres');
    }

    public function detailsMembers(Request $request, Response $response,$args){
        $id = Utils::sanitize($args['id']);
        $user = User::find(intval($id));
        return $this->render($response, 'profil.html.twig',["user"=>$user]);
    }
    public function showUser(Request $request, Response $response, $args) {
        $id = Utils::sanitize($args['id']);
        $user = User::find(intval($id));
        return $this->render($response, 'editProfil.html.twig',['user'=>$user]);
    }

    public function updateUser(Request $request, Response $response, $args) {
        $id = Utils::sanitize($args['id']);
        $user = User::find(intval($id))->first();
        $user->nom = Utils::getFilteredPost($request, "nom");
        $user->prenom = Utils::getFilteredPost($request, "prenom");
        $user->adresse = Utils::getFilteredPost($request, "adresse");
        $user->email = filter_var(Utils::getFilteredPost($request, "email"), FILTER_VALIDATE_EMAIL);
        $user->telephone = Utils::getFilteredPost($request, "telephone");

        $user->save();
        return $this->render($response, 'profil.html.twig',['user'=>$user]);
    }

    //changement du mot de passe
    public function pwdPage(Request $request, Response $response) {
        return $this->render($response, 'changeMdp.html.twig');
    }
    

    //checks for a new user password
    public function changePwd(Request $request, Response $response){
        $id = Utils::sanitize($args['id']);
        $user = User::find(intval($id));
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

}
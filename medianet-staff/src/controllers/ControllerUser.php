<?php

namespace medianet\controllers;

use Cassandra\Date;
use Cassandra\Timestamp;
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

    public function addMember(Request $request, Response $response,$args){
        return $this->render($response, 'addMember.html.twig');
    }

    public function verifMember(Request $request, Response $response){
        $nom = Utils::getFilteredPost($request,'nom');
        $prenom = Utils::getFilteredPost($request,'prenom');
        $adresse = Utils::getFilteredPost($request,'adresse');
        $email = Utils::getFilteredPost($request,'email');
        $telephone = Utils::getFilteredPost($request,'telephone');
        $password = Utils::getFilteredPost($request,'password');
        $confirm_pass = Utils::getFilteredPost($request,'confirm_pass');

        var_dump($email);


        if($nom == "" || $prenom=="" || $adresse== "" || $email=="" || $telephone=="" || $password==""){
            Flash::flashError("Des champ de sont pas completer");
            return Utils::redirect($response, 'ajout_membre');
        }
        if ($confirm_pass != $password){
            Flash::flashError("Confirmation incorrect");
            return Utils::redirect($response, 'ajout_membre');
        }
        $hashed_pass = password_hash($password,PASSWORD_DEFAULT);
        $new_user = new User();
        $new_user->nom = $nom;
        $new_user->prenom = $prenom;
        $new_user->adresse = $adresse;
        $new_user->email = $email;
        $new_user->mdp= $hashed_pass;
        $new_user->telephone = $telephone;

        $new_user->save();

        return Utils::redirect($response,'membres');
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
    public function changePwd(Request $request, Response $response,$args){
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
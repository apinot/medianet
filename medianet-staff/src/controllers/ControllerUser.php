<?php

namespace medianet\controllers;

use Cassandra\Date;
use Cassandra\Timestamp;
use http\Params;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use medianet\models\User;
use medianet\models\Document;
use medianet\models\Emprunt;


class ControllerUser extends Controller {

    public function membersList(Request $request, Response $response){
        $users = User::all();
		return $this->render($response, 'membresListe.html.twig',['users'=>$users]);
    }
    public function afficherProfil(Request $request, Response $response,$args) {
        $id = Utils::sanitize($args['id']);
        return $this->render($response, 'profil.html.twig', compact("user"));
    }

    public function formAjoutUtilisateur(Request $request, Response $response,$args){
        return $this->render($response, 'addMember.html.twig');
    }

    public function addUtilisateur(Request $request, Response $response){
        $nom = Utils::getFilteredPost($request,'nom');
        $prenom = Utils::getFilteredPost($request,'prenom');
        $adresse = Utils::getFilteredPost($request,'adresse');
        $email = Utils::getFilteredPost($request,'email');
        $telephone = Utils::getFilteredPost($request,'telephone');
        $password = Utils::getFilteredPost($request,'password');
        $confirm_pass = Utils::getFilteredPost($request,'confirm_pass');

        if($nom == "" || $prenom == "" || $adresse=="" || $email=="" || $telephone=="" || $password==""){
            Flash::flashError("Des champs de sont pas completer");
            return Utils::redirect($response, 'formUtilisateur');
        }
        if ($confirm_pass != $password){
            Flash::flashError("Confirmation incorrect");
            return Utils::redirect($response, 'formUtilisateur');
        }

        if(!Auth::verifEmail($email)){
            Flash::flashError("Email deja utilisé");
            return Utils::redirect($response, 'formUtilisateur');
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
        $user = User::find($id);

        if (count($user->empruntsEnCours()) == 0) {
            $user->delete();
            Flash::flashSuccess("Le compte a bien été supprimer");
            return Utils::redirect($response, 'membres');
        } else {
            Flash::flashError("Il reste encore des medias empruntés");
            return Utils::redirect($response, 'membres');
        }
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
        $user = User::find($id);
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

    public function recapUser(Request $request, Response $response, $args){
		$idUser = Utils::getFilteredPost($request, 'idUser');
		$emprunts = Emprunt::where("user_id" ,"=", $idUser)->get();
		$this->render($response, 'recap.html.twig', ['emprunts' => $emprunts]);
    }
    
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
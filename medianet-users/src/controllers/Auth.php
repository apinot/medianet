<?php
namespace medianet\controllers;

use medianet\models\User;

//Class de methode static pour faciliter la gestion de la connexion
class Auth {
    //permet de verifier si l utilisateur est connecte
    public static function estConnecte() : bool {
        return isset($_SESSION['user']);
    }

    private static function verifierMdp(string $email, string $mdp) {
        $user = User::where("email", "=", $email)->first();
        return ($user != null && password_verify($mdp, $user->mdp)) ? $user : null;
    }

    public static function modifierMdp(string $ancienMdp, string $nouveauMdp) : bool {   
        $user = self::getUser(); 
        $user = self::verifierMdp($user->email, $ancienMdp);
        if (!$user) { return false; }
        
        $user->mdp = password_hash($nouveauMdp, PASSWORD_DEFAULT);
        return $user->save();
    }

    //permet la deconnexion de l'utilisateur connecter
    public static function deconnexion() {
        unset($_SESSION['user']); 
    }

     //permet de verifier les infos de connexion et creer la connexion si elles sont correctes
    public static function connexion(string $email, string $mdp) : bool {
        if(static::estConnecte()) return true;

        $user = self::verifierMdp($email, $mdp);
        if($user === null) return false;

        $_SESSION['user']['id'] = $user->id;
        return true;
    }

    //retourne l objet user correspondant à celui connecter (retourne null si pas connecter)
    public static function getUser() : User {
        if(!static::estConnecte()) return null;
        return User::find($_SESSION['user']['id']);
    }

    public function verifEmail($email){
        $user = User::where('email','=',$email)->first();
        if ($user == null){
            return true;
        }else{
            return false;
        }
    }

}

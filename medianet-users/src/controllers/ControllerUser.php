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
            // FlashMessage::flashError('email ou mot de passe incorrecte');
            return Utils::redirect($response, 'formConnexion');
        }
        
        // FlashMessage::flashSuccess('Vous êtes connecté en tant que '.$email);
        return Utils::redirect($response, 'home');
    }


    /**
     * fenetre d'edition User
     */
    public function afficherProfil(Request $request, Response $response, $args) {
        $user = User::find($request->getAttribute('id'));
        return $this->views->render($response, 'profil.html.twig', $user);
    }
}
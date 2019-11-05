<?php


namespace medianet\controllers;


use medianet\models\CD;
use medianet\models\Document;
use medianet\models\DVD;
use medianet\models\Livre;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class IndexUserController extends ControllerUser
{

    public function listMedia(Request $request, Response $response){
        $liste_media = array();
        $liste_documents = Document::all();
        $liste_livre = Livre::all();
        $liste_dvd = DVD::all();
        $liste_cd = CD::all();
        foreach ($liste_livre as $livre) {
            array_push($liste_media, [$livre]);
        }
        foreach ($liste_dvd as $dvd) {
            array_push($liste_media, [$dvd]);
        }
        foreach ($liste_documents as $doc) {
            array_push($liste_media, [$doc]);
        }
        foreach ($liste_cd as $cd) {
            array_push($liste_media, [$cd]);
        }

        var_dump($liste_media);
        return $this->view->render($response, 'index.html.twig', ['medias' => $liste_media]);

    }

    public function addToArray($liste1,$liste2){
        foreach ($liste1 as $doc) {
            array_push($liste2, [$doc]);
        }
    }
}
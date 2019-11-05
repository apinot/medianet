<?php


namespace medianet\controllers;


use medianet\models\CD;
use medianet\models\Document;
use medianet\models\DVD;
use medianet\models\Livre;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class IndexUserController extends Controller
{
    public function listMedia(Request $request, Response $response){
        $liste_media = [];
        $liste_documents = Document::all();
        $liste_livre = Livre::all();
        $liste_dvd = DVD::all();
        $liste_cd = CD::all();

        $liste_media=$this->addToArray($liste_documents,$liste_media);
        $liste_media=$this->addToArray($liste_livre,$liste_media);
        $liste_media=$this->addToArray($liste_dvd,$liste_media);
        $liste_media=$this->addToArray($liste_cd,$liste_media);

        return $this->view->render($response, 'index.html.twig', ['medias' => $liste_media]);
    }

    public function addToArray($liste1,$liste2){
        foreach ($liste1 as $doc) {
            array_push($liste2, $doc);
        }
        return $liste2;
    }
}
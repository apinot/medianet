<?php
namespace medianet\controllers;

use medianet\models\Document;
use medianet\models\Livre;
use medianet\models\CD;
use medianet\models\DVD;
use Slim\Exception\NotFoundException;
use Slim\Http\Request;
use Slim\Http\Response;

class ControllerDocument extends Controller {

    public function listMedia(Request $request, Response $response){
        $liste_media = [];
        $liste_documents = Document::all();
        $liste_media=$this->addToArray($liste_documents,$liste_media);
        return $this->view->render($response, 'index.html.twig', ['medias' => $liste_media]);
    }

    public function addToArray($liste1,$liste2){
        foreach ($liste1 as $doc) {
            array_push($liste2, $doc);
        }
        return $liste2;
    }
    
    public function showDocument($request, $response, $args) {
        $idDoc = Utils::sanitize($args['id']);
        $doc = Document::find($idDoc);
        if($doc == null){
            throw new NotFoundException($request, $response);
        }
        
        $type = $doc->documentable_type;
        
        $twigUrl = null;
        switch ($type) {
            case Livre::class:
            $twigUrl  = 'documents/livre.html.twig';
            break;
            case CD::class:
            $twigUrl  = 'documents/cd.html.twig';
            break;
            case DVD::class:
            $twigUrl = 'documents/dvd.html.twig';
            break;
        }
        
        if($twigUrl == null){
            throw new NotFoundException($request, $response);
        }
        
        return $this->render($response, $twigUrl, ['document' => $doc]);
    }

    public function setDisponible(Request $request, Response $response, $args){
        $idDoc = Utils::sanitize($args['id']);
        $doc = Document::find($idDoc);
        $user = Auth::getUser();
        var_dump($doc);
        $doc->disponible = 2;
        $doc->save();
        return Utils::redirect($response, 'home',compact($user));
    }
    
    public function filter($request, $response, $args)
    {
        $queries = [];
        $queries['motcle'] = Utils::getFilteredGet($request, 'keyword');
        $queries['type'] = Utils::getFilteredGet($request, 'doctype');
        $queries['genre'] = Utils::getFilteredGet($request, 'kind');

        $motcle = $queries['motcle'];
        $genre = $queries['genre'];
        $type = $queries['type'];

        $req = Document::where(function ($query) use ($motcle) {
            $motTab = explode(" ", $motcle);

            foreach($motTab as $mot) {
                $query->where(function($subquery) use ($mot) {
                    $subquery->where('nom', 'like', '%'.$mot.'%')
                    ->orWhere('resume', 'like', '%'.$mot.'%');
                });
            }
        });
        
        if($genre !== null && $genre != "") {
            $req->where('genre', 'like', '%'.$genre.'%');
        }
        
        if($type !== null && $type !== "" && $type !== 'all') {
            $req->where('documentable_type', 'like', '%'.$type);
        }
        
        $medias = $req->get();
        
        return $this->view->render($response, 'index.html.twig', ['medias' => $medias, 'query' => $queries]);
    }
}
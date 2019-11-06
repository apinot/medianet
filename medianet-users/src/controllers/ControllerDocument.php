<?php
namespace medianet\controllers;

use medianet\models\Document;
use medianet\models\Livre;
use medianet\models\CD;
use Slim\Exception\NotFoundException;

class ControllerDocument extends Controller {
    
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
            case CD::class:
            $twigUrl = 'documents/dvd.html.twig';
            break;
        }
        
        if($twigUrl == null){
            throw new NotFoundException($request, $response);
        }
        
        return $this->render($response, $twigUrl, ['document' => $doc]);
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
            $query->where('nom', 'like', '%'.$motcle.'%')
            ->orWhere('resume', 'like', '%'.$motcle.'%');
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
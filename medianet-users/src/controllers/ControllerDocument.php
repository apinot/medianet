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
        $mot_clef = Utils::getFilteredGet($request, 'keyword');
        $type = Utils::getFilteredGet($request, 'doctype');
        $genre = Utils::getFilteredGet($request, 'kind');
        
        if (($mot_clef == "" || $mot_clef == null)&&($genre == "" || $genre == null)) {
            switch ($type) {
                case "dvd":
                    $medias = DVD::all();
                    return $this->view->render($response, 'index.html.twig', ['medias' => $medias]);
                    break;
                case "cd":
                    $medias = CD::all();
                    return $this->view->render($response, 'index.html.twig', ['medias' => $medias]);
                    break;
                case "livre":
                    $medias = Livre::all();
                    return $this->view->render($response, 'index.html.twig', ['medias' => $medias]);
                    break;
                default: 
                    $medias = Document::all();
                    return $this->view->render($response, 'index.html.twig', ['medias' => $medias]);
                    break;
            }
        } elseif (($genre == "" || $genre == null)&&($mot_clef != null)) {
            $medias = Document::where("nom", 'like', '%' . $mot_clef . '%')->get();
            return $this->view->render($response, 'index.html.twig', ['medias' => $medias]);
        }
        elseif (($genre != null)&&($mot_clef == "" || $mot_clef == null)) {
            $medias = Document::where("genre", 'like', '%' . $genre . '%')->get();
            return $this->view->render($response, 'index.html.twig', ['medias' => $medias]);
        }
        elseif (($genre != null)&&($mot_clef != null)&&($type == "document")){
            $medias = Document::where("genre", 'like', '%' . $genre . '%')
            ->where("nom", 'like', '%' . $mot_clef . '%')->get();
            return $this->view->render($response, 'index.html.twig', ['medias' => $medias]);
        }
        else{
            return Utils::redirect($response,'home');
        }
        return Utils::redirect($response,'home');
        
    }
    
}
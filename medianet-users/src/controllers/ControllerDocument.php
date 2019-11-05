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
    
}
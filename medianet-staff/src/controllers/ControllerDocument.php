<?php
namespace medianet\controllers;

use medianet\models\Document;
use medianet\models\Livre;
use medianet\models\CD;
use medianet\models\User;
use medianet\models\DVD;
use Slim\Exception\NotFoundException;
use Slim\Http\Request;
use Slim\Http\Response;

class ControllerDocument extends Controller {

    public function modifStatusDocumentIndispo(Request $request, Response $response,$args){
        $id = Utils::sanitize($args['id']);
        $document = Document::find(intval($id));
        $document->disponible = 0;
        $document->save();
        return Utils::redirect($response,'listdoc');
    }

    public function modifStatusDocumentDispo(Request $request, Response $response,$args){
        $id = Utils::sanitize($args['id']);
        $document = Document::find(intval($id));
        $document->disponible = 1;
        $document->save();
        return Utils::redirect($response,'listdoc');
    }



    public function listMedia(Request $request, Response $response){
        $liste_media = [];
        $liste_documents = Document::all();
        $liste_media=$this->addToArray($liste_documents,$liste_media);
        return $this->view->render($response, 'listDocument.html.twig', ['medias' => $liste_media]);
    }

    public function edit(Request $request, Response $response,$args)
    {
        $id = Utils::sanitize($args['id']);
        $document = Document::find(intval($id));
        return $this->view->render($response, 'editDocument.html.twig', ['document' => $document]);

    }

    public function delete(Request $request, Response $response,$args){
        $id = Utils::sanitize($args['id']);
        $document = Document::find(intval($id))->delete();
        return Utils::redirect($response,'listdoc');
    }

    public function addDocument(Request $request, Response $response){
        return $this->view->render($response,'ajouterDocument.html.twig');
    }

    public function verifAddDocument(Request $request, Response $response){
        $type = Utils::getFilteredPost($request,'documentable_type');
        $this->createDOc($type,$response,$request);
        return Utils::redirect($response,'listdoc');

    }

    public function createDOc($type,$response,$request){
        $document = new Document();
        $document->nom = Utils::getFilteredPost($request,'nom');
        $document->resume = Utils::getFilteredPost($request,'resume');
        $document->genre = Utils::getFilteredPost($request,'genre');
        $document->disponible = 1;
        switch($type){
            case "medianet\models\Livre":
                $livre = new Livre();
                $livre->auteur =  Utils::getFilteredPost($request,'auteur');
                $livre->edition =  Utils::getFilteredPost($request,'edition');
                $livre->save();

                $document->documentable_id = $livre->id;
                $document->documentable_type = $type;
                
                $document->save();
                return Utils::redirect($response,'listdoc');
                break;
            case "medianet\models\CD":
                $cd = new CD();
                $cd->artistes =  Utils::getFilteredPost($request,'artistes');
                $cd->maison_disque =  Utils::getFilteredPost($request,'maison_disque');
                $cd->save();

                $document->documentable_id = $cd->id;
                $document->documentable_type = $type;
                $document->save();
                return Utils::redirect($response,'listdoc');
                break;
            case "medianet\models\DVD":
                $dvd = new DVD();
                $dvd->acteurs =  Utils::getFilteredPost($request,'acteurs');
                $dvd->duree =  Utils::getFilteredPost($request,'duree');
                $dvd->save();

                $document->documentable_id = $dvd->id;
                $document->documentable_type = $type;
                $document->save();

                return Utils::redirect($response,'listdoc');
                break;
        }
    }

    public function verif(Request $request, Response $response,$args)
    {
        $id = Utils::sanitize($args['id']);
        $document = Document::find(intval($id));
        $document->nom = Utils::getFilteredPost($request,'nom');
        $document->resume = Utils::getFilteredPost($request,'resume');
        $document->genre = Utils::getFilteredPost($request,'genre');
        $document->disponible = Utils::getFilteredPost($request,'disponible');
        switch ($document->documentable_type){
            case 'medianet\models\CD':
                $media = $document->documentable;
                $media->artistes=Utils::getFilteredPost($request,'artistes');
                $media->maison_disque=Utils::getFilteredPost($request,'maison_disque');
                $media->save();
                $document->save();
                Flash::flashSuccess('Modification effectué');
                return Utils::redirect($response,'listdoc');
                break;
            case 'medianet\models\DVD':
                $media = $document->documentable;
                $media->acteurs=Utils::getFilteredPost($request,'acteurs');
                $media->duree=Utils::getFilteredPost($request,'duree');
                $media->save();
                $document->save();
                Flash::flashSuccess('Modification effectué');
                return Utils::redirect($response,'listdoc');
                break;
            case 'medianet\models\Livre':
                
                $media = $document->documentable;
                $media->auteur=Utils::getFilteredPost($request,'auteur');
                $media->edition=Utils::getFilteredPost($request,'edition');
                $media->save();
                $document->save(); 
                Flash::flashSuccess('Modification effectué');
                return Utils::redirect($response,'listdoc');
                break;
        }

        Flash::flashError('Erreur');
        return Utils::redirect($response,'listdoc');

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
        
        return $this->view->render($response, 'listDocument.html.twig', ['medias' => $medias, 'query' => $queries]);
    }
}
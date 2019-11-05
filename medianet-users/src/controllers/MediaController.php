<?php


namespace medianet\controllers;


use medianet\models\CD;
use medianet\models\Document;
use medianet\models\DVD;
use medianet\models\Livre;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class MediaController extends Controller
{
    public function filter(Request $request, Response $response)
    {
        $mot_clef = Utils::getFilteredPost($request, 'mot_cle');
        $type = Utils::getFilteredPost($request, 'type_media');
        $genre = Utils::getFilteredPost($request, 'genre');

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
                case "document":
                    $medias = Document::all();
                    return $this->view->render($response, 'index.html.twig', ['medias' => $medias]);
                    break;
                case "livre":
                    $medias = Livre::all();
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
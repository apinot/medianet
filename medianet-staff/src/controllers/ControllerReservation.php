<?php
namespace medianet\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use medianet\models\Reservation;

class ControllerReservation extends Controller {

    public function listeReservation(Request $request, Response $response){
        $reservations = Reservation::all();
        return $this->view->render($response, 'reservations.html.twig', ['reservations' => $reservations]);
    }

}
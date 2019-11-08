<?php
namespace medianet\controllers;

use \medianet\models\Reservation;
use \medianet\models\Document;

class ControllerReservation extends Controller {
    
    public function reserver($request, $response, $args) {
        $user = Auth::getUser();

        $docid = Utils::sanitize($args['id']);
        $document = Document::find($docid);
        if($document == null) {
            Flash::flashError("Le document n'existe pas !");
            return Utils::redirect($response, 'home');
        }

        if(!$document->peutEtreReserver()) {
            Flash::flashInfo('Ce document ne peut pas être réservé pour le moment');
            return Utils::redirect($response, 'showDocument', ['id' => $docid]);
        }

        $dateActuelle = date("Y-m-d H:i:s");
        $timeStampProchain = date_timestamp_get(date_create($dateActuelle)) + (3600 * 24 * 7);
        $dateLimite =  date("Y-m-d H:i:s", $timeStampProchain);

        $reservation = new Reservation();
        $reservation->user_id = $user->id;
        $reservation->document_id = $docid;
        $reservation->date_reservation = $dateActuelle;
        $reservation->date_limite = $dateLimite;
        $reservation->save();

        Flash::flashSuccess('Vous avez réservé le document');
        return Utils::redirect($response, 'showDocument', ['id' => $docid]);
    }
}
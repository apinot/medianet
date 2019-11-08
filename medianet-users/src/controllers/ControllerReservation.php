<?php
namespace medianet\controllers;

use \medianet\models\Reservation;

class ControllerReservation extends Controller {
    
    public function reserver($request, $response, $args) {
        $user = Auth::getUser();

        $docid = Utils::sanitize($args['id']);
        $document = Document::find($docid);
        if($document == null) {
            Flash::flashError("Le document n'existe pas !");
            return Utils::redirect($response, 'home');
        }

        if(!peutEtreReserver()) {
            Flash::flashInfo('Ce document ne peut pas être réservé pour le moment');
            return Utils::redirect($response, 'showDocument', ['id' => $docid]);
        }
        $emprunt = $document->emprunts()->whereNull('date_retour')->first();

        $dateActuelle = date("Y-m-d H:i:s");
        $dateFinEmprunt = ( $emprunt !== null ? $emprunt->date_limite : $dateActuelle);
        $timeStampProchain = date_timestamp_get(date_create($dateFinEmprunt)) + (3600 * 24 * 7);
        $dateLimite =  date("Y-m-d H:i:s", $timeStampProchain);

        $reservation = new Reservation();
        $reservation->user_id = $user->id;
        $reservation->document_id = $docid;
        $reservation->date_reservation = $dateActuelle;
        $reservation->date_debut = $dateFinEmprunt;
        $reservation->date_fin = $dateLimite;
        $reservation->save();

        $document->disponible = false;
        $document->save();
    }
}
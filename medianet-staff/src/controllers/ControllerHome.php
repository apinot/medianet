<?php
namespace medianet\controllers;

class ControllerHome extends Controller {

    public function index($request, $response, $args) {
        return $this->render($response, 'base.html.twig');
    }

}

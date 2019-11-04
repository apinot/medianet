<?php

namespace src;

class Accueil {
        function __construct($container){
                $this->c = $container;
                $this->view = $container['view'];
        }
        public function Index($request, $response){
                $response->getBody()->write("ii");
                return $response;
                //return $this->view->render($response, "base.html.twig");
        }
}

?>




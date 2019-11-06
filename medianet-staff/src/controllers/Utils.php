<?php

namespace medianet\controllers;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\UploadedFile;

/**
 * Classe contenant les fonctions utiles fréquemment utilisées
 */
class Utils {
    /**
     * permet la redirection d'un utilisateur
     */
    public static function redirect(ResponseInterface $response, $route, $args = [])
    {
        global $app;
        return $response->withRedirect($app->getContainer()->get('router')->pathFor($route, $args));
    }

   /**
    * Permet de récupérer une variable POST et de la filtrer
    * Retourne null si $key n'est pas présentes dans la requête
    */
    public static function getFilteredPost(ServerRequestInterface $request, string $key) {
        $data = $request->getParsedBodyParam($key, null);
        
        if($data === null) return null;
        if(is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::sanitize($value);
            }
            return $data;
        }

        return self::sanitize($data);
    }

    public static function getFilteredGet(ServerRequestInterface $request, string $key) {
        $data = $request->getQueryParam($key, null);
        
        if($data === null) return null;
        if(is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::sanitize($value);
            }
            return $data;
        }

        return self::sanitize($data);
    }

   /**
    * Permet de sanitize une string (vis-à-vis de l'affichage HTML seulement)
    */
    public static function sanitize(string $unsafe) : string{
        return strip_tags($unsafe);
    }
}
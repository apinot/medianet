<?php
namespace medianet\middlewares;

use medianet\controllers\Auth;
use medianet\controllers\Utils;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use medianet\controllers\Flash;

/**
 * Middleware permettant de vérifier si l'utilisateur est connecté
 */
class AuthMiddleware {

    public function __invoke(Request $request, Response $response, $next) {
        if(!Auth::estConnecte()) {
            return Utils::redirect($response, 'formConnexion');
        }
        return $next($request, $response);
    }
}

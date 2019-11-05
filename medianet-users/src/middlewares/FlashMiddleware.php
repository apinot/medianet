<?php
namespace medianet\middlewares;

use medianet\controllers\Flash;

class FlashMiddleware {
    
    public function __invoke($request, $response, $next) {
        $response = $next($request, $response);
        Flash::next();
        return $response;
    }
}
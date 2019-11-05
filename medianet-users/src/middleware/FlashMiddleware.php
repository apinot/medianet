<?php
namespace oxanaplay\middlewares;

use oxanaplay\controllers\Flash;

class FlashMiddleware {
    
    public function __invoke($request, $response, $next) {
        $response = $next($request, $response);
        Flash::next();
        return $response;
    }
}
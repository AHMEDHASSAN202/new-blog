<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace Application\Middleware;
use System\App;

interface MiddlewareInterface
{
    /**
     * handle the middleware
     *
     * @param $app
     * @param $next flag
     * @return mixed
     */
    public function handler(App $app, $next);
}
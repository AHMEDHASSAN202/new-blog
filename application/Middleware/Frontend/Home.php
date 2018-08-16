<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace Application\Middleware\Frontend;
use Application\Middleware\MiddlewareInterface;
use System\App;

class Home implements MiddlewareInterface
{
    public function handler(App $app, $next)
    {
        // TODO: Implement handler() method.
        return $next;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace Application\Middleware\Admin;
use Application\Middleware\MiddlewareInterface;
use System\App;

class PreventLoginRoute implements MiddlewareInterface
{
    public function handler(App $app, $next)
    {
        // TODO: Implement handler() method.
        isset($app->session->login) ? $code = $app->session->login : null;
        isset($app->cookie->login) ? $code = $app->cookie->login : null;
        if (isset($code)) {
            if ($app->load->model('users')->authUser($code)) {
                redirect(setLink('admin/dashboard'));
            }
        }
        return $next;
    }
}
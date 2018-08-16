<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace Application\Middleware\Admin;
use Application\Middleware\MiddlewareInterface;
use System\App;

class Auth implements MiddlewareInterface
{
    /**
     * Handle The Middleware
     *
     * @param App $app
     * @param \Application\Middleware\flag $next
     * @return mixed|void
     */
    public function handler(App $app, $next)
    {
        if (isset($app->session->login)) $code = $app->session->login;
        if (isset($app->cookie->login)) $code = $app->cookie->login;
        if (isset($code)) {
            $userModel = $app->load->model('users');
            if ($userModel->authUser($code)) {    //is admin
                if (!$app->load->model('PrivilegedUser')->hasPrivilege(
                    $app->request->fullUrl(),
                    'url',
                    $userModel->getUser()->users_group_id
                )) {
                    return show_404(
                        'Access Denied',
                        '<div style="font-size: 80px;">Access Denied</div>',
                        'You Do Not Have Permission',
                        'Go To Back',
                        $app->request->referer(setLink('/admin/dashboard'))
                    );
                }
                return $next;
            }
        }
        return redirect(setLink('admin/login'));
    }
}
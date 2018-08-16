<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace Application\Controllers\Admin\logout;
use System\Controller;

class logoutController extends Controller
{
    /**
     * Logout Link
     *
     * @return void
     */
    public function index()
    {
        $this->app->session->has('login') ? $this->app->session->remove('login') : $this->app->cookie->remove('login');
        redirect(setLink('admin/login'));
    }
}
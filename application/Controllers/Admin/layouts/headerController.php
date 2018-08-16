<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace Application\Controllers\Admin\layouts;
use System\Controller;

class headerController extends Controller
{
    public function render($css = []) {
        return $this->app->view->render('Admin/layouts/header')->css($css);
    }
}
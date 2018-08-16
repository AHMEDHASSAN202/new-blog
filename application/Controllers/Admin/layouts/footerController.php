<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace Application\Controllers\Admin\layouts;
use System\Controller;

class footerController extends Controller
{
    public function render($js = [])
    {
        return $this->app->view->render('Admin/layouts/footer')->js($js);
    }
}
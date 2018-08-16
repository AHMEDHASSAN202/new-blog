<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace Application\Controllers\Frontend\Home;
use System\Controller;
use System\Pagination;

class homeController extends Controller
{
    public function index()
    {

        echo '<h1>Home Page</h1>';
    }
    public function submit()
    {

    }
    public function about() {
        echo 'about';
    }
    public function posts() {
        echo 'posts';
    }

}
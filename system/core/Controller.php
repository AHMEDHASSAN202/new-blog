<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace System;


use System\Views\View;

abstract class Controller
{

    /**
     * Instance of Application Class
     *
     * @var App
     */
    protected $app;

    /**
     * Controller constructor.
     *
     * @param $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        if (strpos($this->app->request->url(), '/admin') !== false) {
            $app->share('adminLayouts', new class($app) {
                private $_app;
                public function __construct(App $app)
                {
                    $this->_app = $app;
                }
                public function render(View $content, $css = [], $js = []) {
                    $data['header'] = $this->_app->load->controller('Admin/layouts/header')->render($css);
                    $data['sidebar'] = $this->_app->load->controller('Admin/layouts/sidebar')->render();
                    $data['content'] = $content;
                    $data['footer'] = $this->_app->load->controller('Admin/layouts/footer')->render($js);
                    return $this->_app->view->render('Admin/layouts/layouts', $data);
                }
            });
        }
    }

    /**
     * Return Json Format
     *
     * @param $data
     * @return mixed
     */
    protected function json($data)
    {
        return $this->app->response->json($data);
    }

    /**
     * Get Property from Application class
     *
     * @param $property
     * @return mixed
     */
    public function __get($property)
    {
        return $this->app->$property;
    }
}
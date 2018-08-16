<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace System\views;

use System\App;

class ViewFactory
{
    /**
     * Application Instance
     *
     * @var object
     */
    private $_app;

    /**
     * ViewFactory constructor
     *
     * @param $app
     */
    public function __construct(App $app)
    {
        $this->_app = $app;
    }

    public function render($view, $data = [])
    {
        return new View($this->_app, $view, $data);
    }
}
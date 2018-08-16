<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace System\Views;
use System\App;

class View
{
    /**
     * Application Instance
     *
     * @var object
     */
    private $_app;

    /**
     * View File
     *
     * @var string
     */
    private $_view;

    /**
     * Data
     *
     * @var array
     */
    private $_data = [];

    /**
     * View Prefix
     *
     * @var string
     */
    const PX = 'View';

    /**
     * View Output
     *
     * @var string
     */
    private $_output;

    /**
     * Css Files
     *
     * @var array
     */
    private $_css = [];

    /**
     * JS Files
     *
     * @var array
     */
    private $_js = [];

    /**
     * View constructor.
     *
     * @param App $app
     * @param $view
     * @param array $data
     * @throws \Exception
     */
    public function __construct(App $app, $view, $data = [])
    {
       $this->_app = $app;
       $this->_view = $this->prepareView($view);
       $this->_data = $data;
    }

    /**
     * Prepare View File
     *
     * @param $view
     * @throws \Exception
     * @return string
     */
    public function prepareView($view)
    {
        $view = str_replace(['/', '\\'], DS , VIEW_PATH . DS . $view . self::PX) . '.php';
        if (!file_exists($view)) {
            throw new \Exception('This View Not Found');
        }
        return $this->_view = $view;
    }

    /**
     * Load Css files
     *
     * @param array $files
     * @return $this
     */
    public function css(array $files)
    {
        $this->_css = $files;
        return $this;
    }

    /**
     * Load JS files
     *
     * @param array $files
     * @return $this
     */
    public function js (array $files)
    {
        $this->_js = $files;
        return $this;
    }

    /**
     * Output View
     *
     * @return string
     */
    public function output()
    {
        if (!$this->_output) {
            ob_start();
            $css = $this->_css;
            $js = $this->_js;
            extract($this->_data);
            require_once $this->_view;
            return $this->_output = ob_get_clean();
        }
    }

    /**
     * View Object
     *
     * @return string
     */
    public function __toString()
    {
        return $this->output();
    }
}
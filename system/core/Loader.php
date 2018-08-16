<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace System;

class Loader
{
    /**
     * Application instance
     *
     * @var object
     */
    private $_app;

    /**
     * Controllers Container
     *
     * @var array
     */
    private $_controllers = [];

    /**
     * Models Container
     *
     * @var array
     */
    private $_models = [];

    /**
     * Helper Prefix
     *
     * @var string
     */
    const HELPER_PX = '_helper';

    /**
     * Helper Prefix
     *
     * @var string
     */
    const CONTROLLER_PX = 'Controller';

    /**
     * Helper Prefix
     *
     * @var string
     */
    const MODEL_PX = 'Model';

    /**
     * Loader constructor
     *
     * @var object
     */
    public function __construct(App $app)
    {
        $this->_app = $app;
    }

    public function action($controller, $method, $arguments)
    {
        $controller = $this->Controller($controller);
        if (!method_exists($controller, $method)) {
            throw new \Exception(sprintf("<b>%s not exists in %s class</b>", $method, $controller));
        }
        return call_user_func_array([$controller, $method], $arguments);
    }

    /**
     * Get Controller
     *
     * @param $controller
     * @return mixed
     */
    public function Controller($controller)
    {
        $controller = $this->generateControllerNamespace($controller);    //generate controller path
        if (!array_key_exists($controller, $this->_controllers)) {
            $this->_controllers[$controller] = new $controller($this->_app);
        }
         return $this->_controllers[$controller];
    }

    /**
     * Generate Controller Path
     *
     * @param $controller
     * @return string
     */
    private function generateControllerNamespace($controller)
    {
        $controller = str_replace('/', '\\', $controller);
        return sprintf('Application\Controllers\%s%s', $controller, self::CONTROLLER_PX);
    }

    /**
     * Get Models
     *
     * @param $model
     * @return mixed
     */
    public function model($model)
    {
        $model = $this->generateModelNamespace($model);
        if (!array_key_exists($model, $this->_models)) {
            $this->_models[$model] = new $model($this->_app);
        }
        return $this->_models[$model];
    }

    /**
     * Generate The Namespace For Models
     *
     * @param $model
     * @return string
     */
    private function generateModelNamespace($model)
    {
        $model = str_replace('/', '\\', $model);
        return sprintf('Application\Models\%s%s', $model, self::MODEL_PX);
    }

    /**
     * Load Helper File
     *
     * @param $file
     * @return mixed
     */
    public function helper($file)
    {
        return $this->_app->file->require(SYSTEM_PATH . DS . 'helpers' . DS . $file . self::HELPER_PX);
    }

}
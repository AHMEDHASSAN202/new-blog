<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace System\Routes;
use System\App;
use System\Config;

class Router
{
    /**
     * Application Class
     *
     * @var App
     */
    private $_app;

    /**
     * Prefix Routes Files
     *
     * @const string
     */
    private const PX = '_rs';

    /**
     * Middleware Flag
     *
     * @var string
     */
    const NEXT =  '__NEXT__';

    /**
     * Routes Container
     *
     * @var array
     */
    private $_routes = [];

    /**
     * Patterns Url
     *
     * @var array
     */
    private $_patterns = [
        ':id'       => '(\d+)',
        ':text'     => '([\p{Arabic}a-zA-Z0-9-]+)',
        ':any'      => '(.*)'
    ];

    /**
     * Prefix URL Group
     *
     * @var string
     */
    private $_prefix;

    /**
     * Controller Group
     *
     * @var string
     */
    private $_baseController;

    /**
     * Middleware Group
     *
     * @var array
     */
    private $_middleware = [];

    private $_routesNames = [];

    /**
     * Router constructor
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->_app = $app;
    }

    /**
     * Load Routes Files
     *
     * @return void
     */
    public function loadRoutesFiles()
    {
        foreach(Config::get('routes') as $file) {
            $routeFile = $file . self::PX;
            $this->_app->file->require($routeFile);
        }
    }

    /**
     * Add Route
     *
     * @param $url
     * @param $action
     * @param $requestMethod
     * @param array $middleware
     * @param $NoPrefix boolean
     * @return array
     */
    public function add($url,
                        $action,
                        $requestMethod = "GET",
                        array $middleware = [],
                        $NoPrefix = false) {
        $str = explode('|',$requestMethod, 2);
        $requestMethod = $str[0];
        $isAjax = isset($str[1]) && $str[1] == 'ajax' ? true: false;

        if ($this->_prefix && !$NoPrefix) {
            $url = $this->_prefix == '/' ? '' . $url : $this->_prefix . $url;
        }
        if ($this->_baseController) {
            $action = $this->_baseController . $action;
        }
        if (!empty($this->_middleware)) {
            $middleware = array_merge($this->_middleware, $middleware);
        }

        $this->_routes[] = [
            'url'           => $url,
            'pattern'       => $this->getPattern($url),
            'action'        => $this->getAction($action),
            'requestMethod' => strtoupper($requestMethod),
            'isAjax'        => $isAjax,
            'middleware'   => $middleware
        ];
        return $this;
    }

    /**
     * Get Pattern
     *
     * @param $url
     * @return string
     */
    public function getPattern($url)
    {
        return '#^' .  str_replace(array_keys($this->_patterns), array_values($this->_patterns), $url) . '$#u';
    }

    /**
     * Get Action
     *
     * @param $action
     * @return string
     */
    private function getAction($action)
    {
        return strpos($action, '@') === false ? $action .'@index' : $action;
    }

    /**
     * Group Routes
     *
     * @param array $groupOptions
     * @param callable $func
     * @return $this
     */
    public function group(array $groupOptions, callable $func)
    {
        $prefix = array_get($groupOptions, 'prefix');
        $controller = array_get($groupOptions, 'controller');
        $middleware = (array) array_get($groupOptions, 'middleware');
        if (
            ($this->_prefix && $this->_prefix !== $prefix)
            OR
            (strpos($this->_app->request->url(), $prefix) !== 0)
        ) {
            return $this;
        }

        $this->_prefix = $prefix;
        $this->_baseController = $controller;
        $this->_middleware = $middleware;
        $func($this);
        $this->_baseController = '';
        $this->_middleware = [];
    }

    /**
     * Get Proper Route
     *
     * @return string
     * @throws \Exception || string
     */
    public function properRoute()
    {
        foreach ($this->_routes as $route) {
            if ($this->isMatchRoute($route)) {
                $output = '';
                //check if exists middleware
                if ($route['middleware']) {
                    $middlewareInterface = str_replace('/','\\',Config::get('middleware/interface'));
                    foreach($route['middleware'] AS $middleware) {
                        $middleware = str_replace('/', '\\', Config::get('middleware/directory'). $middleware);
                        if (!in_array($middlewareInterface, class_implements($middleware))) {
                            throw new \Exception(sprintf('%s must by implement of %s', $middleware, $middlewareInterface));
                        }
                        //create object from middleware class
                        $middlewareObject = new $middleware;
                        //get the output of handler method to chick it
                        $output = $middlewareObject->handler($this->_app, self::NEXT);
                        if ($output) {
                            if ($output === self::NEXT) {
                                $output = '';
                            }else {
                                //it means middleware has returned another value than the next flag
                                //so this value will be returned for the response output
                                break;
                            }
                        }
                    }
                }

                //if there the output value,
                //then we are not going to execute the route controller
                //otherwise, we are going to execute the route controller
                if ($output == '') {
                    //get controller and method
                    [$controller, $method] = explode('@',$route['action']);
                    $arguments = $this->getArguments($route['pattern']);
                    $output = $this->_app->load->action($controller, $method, $arguments);
                }

                return (string) $output;
            }
        }
        show_404(null, null, null, null, setLink('home')); //error page [404]
    }

    /**
     * Determine if any Route From Routes array Match The Current Route
     *
     * @param array $route
     * @return bool
     */
    private function isMatchRoute(array $route) :bool
    {
        if (
            preg_match($route['pattern'], $this->_app->request->url())
            &&
            $route['requestMethod'] === $this->_app->request->method()
            &&
            $this->_app->request->isAjax() === $route['isAjax']
        ) return true;
        return false;
    }

    /**
     * Get Arguments From Current Url
     *
     * @param $pattern
     * @return mixed
     */
    private function getArguments($pattern)
    {
        preg_match($pattern, $this->_app->request->url(), $arguments);
        array_shift($arguments);
        return $arguments;
    }

    /**
     * Get All Routes
     *
     * @return array
     */
    public function getRoutes() :array
    {
        return $this->_routes;
    }

    /**
     * Add Package Of Routes For CRUD
     *
     * @param $url
     * @param $controller
     */
    public function package($url, $controller)
    {
        $this->add("$url" , "$controller");
        $this->add("$url/add" , "$controller@add", 'POST');
        $this->add("$url/submit" , "$controller@submit", 'POST');
        $this->add("$url/edit/:id" , "$controller@edit", 'POST');
        $this->add("$url/save/:id" , "$controller@save", 'POST');
        $this->add("$url/delete/:id" , "$controller@delete", 'POST');
    }

    public function name($name) {
        $this->_routesNames[] = ['name' => $name];
    }
}
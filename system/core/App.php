<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace System;


class App
{
    /**
     * Store Instance From This Class
     *
     * @var null
     */
    private static $_instance = null;

    /**
     * Container Classes
     *
     * @var array
     */
    private $_containerClasses = [];

    /**
     * Core Classes
     *
     * @var array
     */
    private $_coreClasses = [
        'request'       => 'System\\Request',
        'response'      => 'System\\Response',
        'route'         => 'System\\Routes\\Router',
        'load'          => 'System\\Loader',
        'session'       => 'System\\Session',
        'cookie'        => 'System\\Cookie',
        'db'            => 'System\\Database',
        'input'         => 'System\\Input',
        'html'          => 'System\\Html',
        'view'          => 'System\\Views\\ViewFactory',
        'pagination'    => 'System\\Pagination',
        'validation'    => 'System\\Validation'
    ];

    /**
     * App constructor.
     *
     * @param $file
     * @return mixed
     */
    private function __construct(File $file)
    {
        $this->share('file', $file);
        $this->LoadHelpersFiles();
    }


    /**
     * Get Instance
     *
     * @param File $file
     * @return null
     */
    public static function getInstance(File $file = null)
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self($file);
        }
        return self::$_instance;
    }

    /**
     * Run Application
     *
     * @void
     */
    public function run()
    {
        $this->session->start();
        $this->request->prepareUrl();  //prepare url
        $this->route->loadRoutesFiles(); //load routes files
        $output = $this->route->properRoute();   //get proper route and send output [view]
        $this->response->setOutput($output);    //set output view
        $this->response->send();   //send headers and view to browser
    }

    /**
     * Share Class in Container Classes
     *
     * @param $class
     * @param $obj
     */
    public function share($class, $obj)
    {
        if ($obj instanceof \Closure) {
            $obj = call_user_func($obj, $this);
        }

        $this->_containerClasses[$class] = $obj;
    }

    /**
     * Get Object From Container Classes
     *
     * @param $class
     * @return mixed
     */
    private function get($class)
    {
       if (!array_key_exists($class , $this->_containerClasses)) {
           if (array_key_exists($class, $this->_coreClasses)) {
               $this->createObjectAndInsertIntoContainerClasses($class);
           }else {
               die('<b>' . $class . '</b> Class Not Exists ('. __METHOD__ .')');
           }
       }

       return $this->_containerClasses[$class];
    }

    /**
     * Create Object From Core Classes and Insert it into The Container Classes
     *
     * @param $class
     */
    private function createObjectAndInsertIntoContainerClasses($class)
    {
        $obj = new $this->_coreClasses[$class]($this);
        $this->_containerClasses[$class] = $obj;
    }

    /**
     * Magic Method __get
     *
     * @param $property
     * @return mixed
     */
    public function __get($property)
    {
        return $this->get($property);
    }

    /**
     * Require Common Functions File From Core Folder
     *
     * @return void
     */
    private function LoadHelpersFiles()
    {
        $helpers  = (array) Config::get('autoload_helpers_files');
        foreach ($helpers AS $helper) {
            $this->load->helper($helper);
        }
    }

}
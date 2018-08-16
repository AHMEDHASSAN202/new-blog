<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace System;


class Input
{

    /**
     * Application instance
     *
     * @var $_app;
     */
    private $_app;

    /**
     * Store Files Objects
     *
     * @var array
     */
    private $_files = [];

    /**
     * Input constructor.
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->_app = $app;
    }

    /**
     * Get Value From $_GET
     *
     * @param $key
     * @param $default
     * @return bool
     */
    public function get($key, $default = null)
    {
        return array_get($_GET, $key, $default);
    }

    /**
     * Check if $_GET is Not Empty
     *
     * @return bool
     */
    public function inGet()
    {
        return !empty($_GET);
    }

    /**
     * Set Value In $_GET array
     *
     * @param $key
     * @param $value
     * @return mixed
     */
    public function setGet($key, $value)
    {
        return $_GET[$key] = $value;
    }

    /**
     * Get Value From $_POST
     *
     * @param $key
     * @param $default
     * @return bool
     */
    public function post($key, $default = null)
    {
        return array_get($_POST, $key, $default);
    }

    /**
     * Get All Posts Request
     *
     * @return bool
     */
    public function postArray()
    {
        return $_POST ?? false;
    }

    /**
     * Check if $_GET is Not empty
     *
     * @return bool
     */
    public function inPost()
    {
        return !empty($_POST);
    }

    /**
     * Get Value From $_REQUEST
     *
     * @param $key
     * @param $default
     * @return value || bool
     */
    public function request($key, $default = null)
    {
        return array_get($_REQUEST, $key, $default);
    }

    /**
     * Stored File Object in $_files array
     *
     * @param $file
     * @return mixed
     */
    public function file($file)
    {
        if (!array_key_exists($file, $this->_files)) {
            $this->_files[$file] = new UploadedFile($this->_app, $file);
        }
        return $this->_files[$file];
    }
}
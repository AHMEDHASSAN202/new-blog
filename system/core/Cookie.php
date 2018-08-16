<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace System;


class Cookie
{
    /**
     * Application Instance
     *
     * @var object $app
     */
    private $_app;

    /**
     * Default Path Cookies
     *
     * @var string
     */
    private $_defaultPath = '/';

    /**
     * Default Domain
     *
     * @var string
     */
    private $_defaultDomain = '';

    /**
     * Default Secure
     *
     * @var bool
     */
    private $_defaultSecure = false;

    /**
     * Default HTTP only
     *
     * @var bool
     */
    private $_defaultHttpOnly = true;

    const HOUR = 3600;
    const DAY = (self::HOUR * 24);
    const WEEK = (self::DAY * 7);
    const MONTH = (self::DAY * 30);
    const YEAR = (self::MONTH * 12);

    /**
     * Cookie constructor
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->_app = $app;
    }

    /**
     * Set Cookie
     *
     * @param $name
     * @param $value
     * @param null $time
     * @param null $path
     * @param null $domain
     * @param null $secure
     * @param null $httpOnly
     * @return bool
     */
    public function set($name, $value, $time=null, $path=null, $domain=null, $secure=null, $httpOnly=null)
    {
        $time = $time !== -1 ? time() + ($time ?? self::MONTH) : time() - 3600;
        $path = $path ?? $this->_defaultPath;
        $domain = $domain ?? $this->_defaultDomain;
        $secure = $secure ?? $this->_defaultSecure;
        $httpOnly = $httpOnly ?? $this->_defaultHttpOnly;

        $_COOKIE[$name] = $value;
        return setcookie($name, $value, $time, $path, $domain, $secure, $httpOnly);
    }

    /**
     * Get Cookie
     *
     * @param $name
     * @return mixed
     */
    public function get($name)
    {
        return $_COOKIE[$name];
    }

    /**
     * Check if has Cookie
     *
     * @param $name
     * @return bool
     */
    public function has($name)
    {
        return isset($_COOKIE[$name]);
    }

    /**
     * Remove Cookie
     *
     * @param $name
     * @return mixed
     */
    public function remove($name)
    {
        $this->set($name, '', -1);
        unset($_COOKIE[$name]);
    }

    /**
     * Remove all Cookies [destroy cookies]
     *
     * @return void
     */
    public function kill()
    {
        foreach ($_COOKIE AS $key => $value) {
            $this->remove($key);
        }
    }

    /**
     * Get all Cookies
     *
     * @return mixed
     */
    public function all()
    {
        return $_COOKIE;
    }

    /**
     * Check Cookie
     *
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($_COOKIE[$name]) ? true : false;
    }

    /**
     * Get Cookie Value
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * Set Cookies
     *
     * @param $name
     * @param $value
     * @return bool
     */
    public function __set($name, $value)
    {
        return $this->set($name, $value);
    }
}
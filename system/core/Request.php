<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace System;


class Request
{
    /**
     * Application instance
     *
     * @var App
     */
    private $_app;

    /**
     * Base Url
     *
     * @var string
     */
    private $baseUrl;

    /**
     * Url
     *
     * @var string
     */
    private $url;

    /**
     * Request constructor.
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->_app = $app;
    }

    /**
     * Prepare Url
     *
     * @return void
     */
    public function prepareUrl()
    {
        $this->baseUrl = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'];
        $url = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
        if (strpos($url, '?') !== false) {
            [$url, $bla] = explode('?', $url);
        }
        $this->url = urldecode($url);
    }

    /**
     * Get Url
     *
     * @return null|string
     */
    public function url()
    {
        return $this->url;
    }

    /**
     * Get Base Url
     *
     * @return string
     */
    public function baseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * Get Full URL
     *
     * @return string
     */
    public function fullUrl()
    {
        return $this->baseUrl . $this->url();
    }

    /**
     * Get Value From $_SERVER array
     *
     * @param string $key
     * @return null
     */
    public function server(string $key)
    {
        return array_get($_SERVER, $key);
    }

    /**
     * Get Request Method
     *
     * @param $upper
     * @return string
     */
    public function method(bool $upper = true)
    {
        return ($upper) ? strtoupper($this->server('REQUEST_METHOD')) : strtolower($this->server('REQUEST_METHOD'));
    }

    /**
     * Get The address of the page (if any) which referred the user agent to the current page
     *
     * @param $default;
     * @return null
     */
    public function referer($default = null)
    {
        return array_get($_SERVER, 'HTTP_REFERER', $default);
    }

    /**
     * Check if is Ajax Request
     *
     * @return bool
     */
    public function isAjax()
    {
        return ((array_get($_SERVER, 'HTTP_X_REQUESTED_WITH', false)) === 'XMLHttpRequest') ? true : false;
    }

    /**
     * Find Real IP address
     *
     * @return mixed
     */
    public function getIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}
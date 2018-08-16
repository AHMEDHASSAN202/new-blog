<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace System;

class Response
{
    /**
     * Application instance
     *
     * @var $_app
     */
    private $_app;

    /**
     * Output View
     *
     * @var object
     */
    private $_output;

    /**
     * Headers
     *
     * @var array
     */
    private $_headers = [];

    /**
     * Response constructor
     *
     * @param \System\App $app
     */
    public function __construct(App $app)
    {
        $this->_app = $app;
    }

    /**
     * Set output
     *
     * @param $output
     */
    public function setOutput($output)
    {
        $this->_output = $output;
    }

    /**
     * Get output
     *
     * @return void
     */
    public function getOutput()
    {
        echo $this->_output;
    }

    /**
     * Set Header
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function setHeader(string $key, string $value)
    {
        $this->_headers[$key] = $value;
        return $this;
    }

    /**
     * Get Headers
     *
     * @return void
     */
    public function getHeaders()
    {
        foreach ($this->_headers AS $key => $value) {
            header($key . ':' . $value);
        }
    }

    /**
     * Send Headers and View to browser
     *
     * @return void
     */
    public function send()
    {
        $this->getHeaders();
        $this->getOutput();
    }

    /**
     * Send Json Data
     *
     * @param $data
     * @return string
     */
    public function json($data) {
        return json_encode($data);
    }
}
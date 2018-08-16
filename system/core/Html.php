<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace System;


class Html
{
    /**
     * Application instance
     *
     * @var object
     */
    private $_app;

    /**
     * Title
     *
     * @var string
     */
    private $_title;

    /**
     * Description
     *
     * @var string
     */
    private $_description;

    /**
     * Keywords
     *
     * @var string
     */
    private $_keywords;

    /**
     * Favicon
     *
     * @var string
     */
    private $_favicon;

    /**
     * Html constructor
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->_app = $app;
    }

    /**
     * Set Title
     *
     * @param $title
     */
    public function setTitle($title)
    {
        $this->_title = $title;
    }

    /**
     * Get Title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * Set Description
     *
     * @param $desc
     */
    public function setDescription($desc)
    {
        $this->_description = $desc;
    }

    /**
     * Get Description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * set Keywords
     *
     * @param $keywords
     */
    public function setKeywords($keywords)
    {
        $this->_keywords = $keywords;
    }

    /**
     * Get Keywords
     *
     * @return string
     */
    public function getKeywords()
    {
        return $this->_keywords;
    }

    /**
     * Set Favicon
     *
     * @param $iconPath
     * @return void
     */
    public function setFavicon($iconPath)
    {
        $this->_favicon = $iconPath;
    }

    /**
     * Get Favicon
     *
     * @return string
     */
    public function getFavicon()
    {
        return $this->_favicon;
    }
}
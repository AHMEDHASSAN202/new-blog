<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace System;


class UploadedFile
{
    /**
     * Application Instance
     *
     * @var App
     */
    private $_app;

    /**
     * File
     *
     * @param array
     */
    private $_file = [];

    /**
     * File Name
     *
     * @var string
     */
    private $_name;

    /**
     * File Extension
     *
     * @var string
     */
    private $_extension;

    /**
     * File Full Name
     *
     * @var string
     */
    private $_fullName;

    /**
     * File Type
     *
     * @param string
     */
    private $_type;

    /**
     * File Size
     *
     * @param int
     */
    private $_size;

    /**
     * Temporary Name
     *
     * @var string
     */
    private $_tempName;

    /**
     * Errors
     *
     * @var array
     */
    private $_errors = [];

    /**
     * Image extensions
     *
     * @var array
     */
    private $_imageExtensions = ['jpg', 'jpeg', 'png', 'giv', 'gif', 'webp'];

    /**
     * Store name file after move it
     *
     * @var string
     */
    private $_nameAfterMoved;

    //Constants Size
    const KB =  1024;
    const MB =  1048576;
    const GB = 1073741824;

    /**
     * UploadedFile constructor
     *
     * @param App $app
     * @param $file
     */
    public function __construct(App $app, $file)
    {
        $this->_app = $app;
        $this->infoFile($file);
    }

    /**
     * Add Error
     *
     * @param string
     */
    private function addError($error)
    {
        $this->_errors[] = $error;
    }

    /**
     * Get information and set properties
     *
     * @param $file
     */
    public function infoFile($file)
    {

        if (empty($_FILES[$file])) {
            return $this->addError(sprintf('%s not exists', $file));
        }

        if ($_FILES[$file]['error'] !== UPLOAD_ERR_OK) {
            $this->addError(sprintf('Sorry, there was an errors uploading your %s',$file));
        }
        $this->_file = $_FILES[$file];
        $this->_fullName = $this->_file['name'];
        $this->_name = pathinfo($this->_fullName, PATHINFO_FILENAME);
        $this->_extension = pathinfo($this->_fullName, PATHINFO_EXTENSION);
        $this->_tempName = $this->_file['tmp_name'];
        $this->_size = $this->_file['size'];
        $this->_type = $this->_file['type'];
    }

    /**
     * Check if there error
     *
     * @return bool
     */
    public function hasErrors() :bool {
        return !empty($this->_errors);
    }

    /**
     * Get Errors
     *
     * @return array
     */
    public function errors() : array
    {
        return $this->_errors;
    }

    /**
     * Check if file is image
     *
     * @return bool
     */
    public function isImage() : bool
    {
        if (!in_array(strtolower($this->_extension), $this->_imageExtensions)) {
            $this->addError('only allowed '. implode(' , ', $this->_imageExtensions));
            return false;
        }
        return true;
    }

    /**
     * Check if uploaded file
     *
     * @return bool
     */
    public function uploaded() : bool
    {
        return (bool) ($this->_size > 0);
    }

    /**
     * Get name
     *
     * @return string
     */
    public function name()
    {
        return $this->_name;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function extension()
    {
        return $this->_extension;
    }

    /**
     * Get Full name
     *
     * @return string
     */
    public function fullName()
    {
        return $this->_fullName;
    }

    /**
     * Get Temporary name
     *
     * @return string
     */
    public function tempName()
    {
        return $this->_tempName;
    }

    /**
     * Get Type
     *
     * @return mixed
     */
    public function type()
    {
        return $this->_type;
    }

    /**
     * Move Files
     *
     * @param $path
     * @param null $newName
     * @return bool
     * @throws \Exception
     */
    public function move($path, $newName = null) : bool
    {
        if (!is_dir($path)) {
            if (!mkdir($path, 0777, true)) {
                throw new \Exception('Failed to create folder '. $path);
            }
        }
        $name = $newName ?? sha1(mt_rand() . time() . mt_rand());
        $this->_nameAfterMoved = $name .= '.' . $this->_extension;
        return move_uploaded_file($this->_tempName, $path . $this->_nameAfterMoved);
    }

    /**
     * Get file name after moved it
     *
     * @return string
     */
    public function nameAfterMoved()
    {
        return $this->_nameAfterMoved;
    }

}
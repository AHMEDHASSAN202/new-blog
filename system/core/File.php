<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace System;


class File
{

    /**
     * Require File
     *
     * @param $path
     * @throws \Exception
     */
    public function require($path)
    {
        $file = $path . '.php';

        if (!file_exists($file)) {
            throw new \Exception(sprintf(' %s not exists in this path', $file));
        }

        require_once $file;
    }

    /**
     * Remove file
     *
     * @param $file
     * @return bool
     */
    public function remove($file)
    {
        if (!file_exists($file)) {
            return false;
        }
        return unlink($file);
    }
}
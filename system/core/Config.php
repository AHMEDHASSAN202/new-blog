<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace System;


class Config
{
    /**
     * Configurations
     *
     * @var array
     */
    private static $_configArray = [];

    /**
     * Config constructor
     *
     * @void
     */
    public function __construct()
    {
        $configFile = SYSTEM_PATH . DS . 'config.php';

        if (!file_exists($configFile)) die("<b>Config File Not Found</b>");

        static::$_configArray = require $configFile;
    }

    /**
     * Get Value From Config File
     * Using: System/Config::get($value);
     *
     * @param $value
     * @return bool|mixed
     */
    public static function get($value)
    {
        /**
         * if $value = database/name  (string)
         *
         * EXPLODE
         * $keys = [0] => database , [1] => name  (array)
         *
         */
        if ($value) {
            $config = static::$_configArray;
            $values = explode('/', $value);
            foreach($values as $val) {
                if (isset($config[$val])) {
                    $config = $config[$val];
                }
            }
            return $config;
        }
        return false;
    }

    /**
     * Set Environment Application
     *
     * @Void
     */
    public static function setEnvironment()
    {
        switch (ENVIRONMENT) {
            case "development" :
                ini_set('display_errors', 1);
                $whoops = new \Whoops\Run;
                $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
                $whoops->register();
                break;
            case "production" :
                ini_set('display_errors', 0);
                break;
            default :
                die("Environment is not set");
        }
    }

    /**
     * Check Version PHP
     *
     * @return void
     */
    public static function phpVersion()
    {
        if (version_compare(PHP_VERSION, self::get('php_least_version')) === -1) {
            die("<b>PHP Version Must be Upper Than ".self::get('php_least_version')."</b>");
        }
    }

    /**
     * Set Default Timezone
     *
     * @return void
     */
    public static function setTimezone()
    {
        date_default_timezone_set(self::get('date/set_timezone'));
    }
}
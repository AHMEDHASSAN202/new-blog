<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace System;


class Session extends \SessionHandler
{
    /**
     * Application instance
     *
     * @var $app
     */
    private $_app;

    /**
     * Key
     *
     * @var string
     */
    private $_key;

    /**
     * Session constructor.
     *
     * @param App $app
     */
    public function __construct(App $app = null)
    {
        $this->_app = $app;

        if (! extension_loaded('openssl')) {
            throw new \RuntimeException(sprintf(
                "You need the OpenSSL extension to use %s",
                __CLASS__
            ));
        }
        if (! extension_loaded('mbstring')) {
            throw new \RuntimeException(sprintf(
                "You need the Multibytes extension to use %s",
                __CLASS__
            ));
        }

        ini_set('session.use_cookies', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.use_trans_sid', 0);
        ini_set('session.save_handler', 'files');
        ini_set('session.use_strict_mode', 1);

        session_name(Config::get('session/name'));
        session_save_path(Config::get('session/savePath'));
        session_set_cookie_params(
            Config::get('session/maxLifeTime'),
            Config::get('session/path'),
            Config::get('session/domain'),
            Config::get('session/SSL'),
            Config::get('session/HTTPOnly')
        );
        session_set_save_handler($this, true);
    }

    /**
     * Open the session
     *
     * @param string $save_path
     * @param string $session_name
     * @return bool
     * @throws \Exception
     */
    public function open($save_path, $session_name)
    {
        $this->_key = $this->getKey('KEY_' . $session_name);
        return parent::open($save_path, $session_name);
    }

    /**
     * Session Start
     *
     * @return mixed
     */
    public function start()
    {
        if (session_id() === '') {
            return session_start();
        }
    }

    /**
     * Read from session and decrypt
     *
     * @param string $id
     * @return string
     */
    public function read($id)
    {
        $data = parent::read($id);
        return empty($data) ? '' : $this->decrypt($data, $this->_key);
    }

    /**
     * Encrypt the data and write into the session
     *
     * @param string $id
     * @param string $data
     * @return bool
     * @throws \Exception
     */
    public function write($id, $data)
    {
        return parent::write($id, $this->encrypt($data, $this->_key));
    }

    /**
     * Encrypt and authenticate
     *
     * @param $data
     * @param $key
     * @return string
     * @throws \Exception
     */
    private function encrypt($data, $key)
    {
        $iv = random_bytes(16); // AES block size in CBC mode
        // Encryption
        $ciphertext = openssl_encrypt(
            $data,
            'AES-256-CBC',
            mb_substr($key, 0, 32, '8bit'),
            OPENSSL_RAW_DATA,
            $iv
        );
        // Authentication
        $hmac = hash_hmac(
            'SHA256',
            $iv . $ciphertext,
            mb_substr($key, 32, null, '8bit'),
            true
        );
        return $hmac . $iv . $ciphertext;
    }

    /**
     * Authenticate and decrypt
     *
     * @param string $data
     * @param string $key
     * @return string
     */
    private function decrypt($data, $key)
    {
        $hmac       = mb_substr($data, 0, 32, '8bit');
        $iv         = mb_substr($data, 32, 16, '8bit');
        $ciphertext = mb_substr($data, 48, null, '8bit');
        // Authentication
        $hmacNew = hash_hmac(
            'SHA256',
            $iv . $ciphertext,
            mb_substr($key, 32, null, '8bit'),
            true
        );
        if (! hash_equals($hmac, $hmacNew)) {
            throw new Exception('Authentication failed');
        }
        // Decrypt
        return openssl_decrypt(
            $ciphertext,
            'AES-256-CBC',
            mb_substr($key, 0, 32, '8bit'),
            OPENSSL_RAW_DATA,
            $iv
        );
    }

    /**
     * Get the encryption and authentication keys from cookie
     *
     * @param $name
     * @return bool|string
     * @throws \Exception
     */
    private function getKey($name)
    {
        if (empty($_COOKIE[$name])) {
            $key         = random_bytes(64); // 32 for encryption and 32 for authentication
            $cookieParam = session_get_cookie_params();
            $encKey      = base64_encode($key);
            setcookie(
                $name,
                $encKey,
                // if session cookie lifetime > 0 then add to current time
                // otherwise leave it as zero, honoring zero's special meaning
                // expire at browser close.
                ($cookieParam['lifetime'] > 0) ? time() + $cookieParam['lifetime'] : 0,
                $cookieParam['path'],
                $cookieParam['domain'],
                $cookieParam['secure'],
                $cookieParam['httponly']
            );
            $_COOKIE[$name] = $encKey;
        } else {
            $key = base64_decode($_COOKIE[$name]);
        }
        return $key;
    }

    /**
     * Set Session
     *
     * @param $key
     * @param $value
     * @return mixed
     */
    public function set($key, $value)
    {
        return $_SESSION[$key] = $value;
    }

    /**
     * Get Session
     *
     * @param $key
     * @return value
     */
    public function get($key)
    {
        return $_SESSION[$key];
    }

    /**
     * Determine if Key Exists
     *
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        return isset($this->$key);
    }


    /**
     * Get All Session
     *
     * @return array
     */
    public function all()
    {
        return $_SESSION ?? [];
    }

    /**
     * Remove session
     *
     * @param $key
     */
    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    /**
     * Kill Session [destroy session]
     *
     * @return mixed
     */
    public function kill()
    {
        session_unset();
        session_destroy();
    }

    /**
     * Get Session
     *
     * @param $key
     * @return value
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * Set Session
     *
     * @param $key
     * @param $value
     * @return mixed
     */
    public function __set($key, $value)
    {
        return $this->set($key, $value);
    }

    /**
     * Check if Exists session
     *
     * @param $key
     * @return bool
     */
    public function __isset($key)
    {
        return isset($_SESSION[$key]) ? true : false;
    }

}
<?php
/**
 * Encryption and Decryption Data
 *
 * @uses openssl plugins
 * ================================================================
 */

define('OPENSSL_INFO' , [
    'cipher_method' => 'AES-128-CBC',
    'key'           => openssl_random_pseudo_bytes(62),
    'iv'            => openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-128-CBC'))
]);

if (!function_exists('encrypt')) {
    /**
     * Encrypt Data by openssl library
     *
     * @param $data
     * @return string
     * @throws Exception
     */
    function encrypt($data) {
        return base64_encode(openssl_encrypt($data, OPENSSL_INFO['cipher_method'], OPENSSL_INFO['key'], $options=0, OPENSSL_INFO['iv']));
    }
}

if (!function_exists('decrypt')) {
    /**
     * Decrypt Data by openssl library
     *
     * @param $data
     * @return string
     * @throws Exception
     */
    function decrypt($data) {
        return openssl_decrypt(base64_decode($data), OPENSSL_INFO['cipher_method'], OPENSSL_INFO['key'], $options=0, OPENSSL_INFO['iv']);
    }
}
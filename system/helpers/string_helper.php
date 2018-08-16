<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */
if (!function_exists('cut_text')) {
    /**
     * Cut Part OF Text
     *
     * @param $number
     * @param $text
     * @return array|string
     */
    function cut_text($number, $text)
    {
        if (str_word_count($text) > $number) {
            $text = explode(' ', $text);
            $text = array_slice($text, 0, ($number-1));
            $text = implode(' ', $text) . ' ....';
        }
        return $text;
    }
}
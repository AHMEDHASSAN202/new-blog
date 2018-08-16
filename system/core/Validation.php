<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

namespace System;


class Validation
{
    /**
     * Application Class
     *
     * @var object
     */
    private $app;

    /**
     * Container Errors
     *
     * @var array
     */
    private $errors = [];

    /**
     * Validation Constructor
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * Add Error
     *
     * @param $input
     * @param $error
     */
    public function addError($input , $error)
    {
        $this->errors[$input] = $error;
    }

    /**
     * Check If Input has Error
     *
     * @param $input
     * @return bool
     */
    private function hasError($input)
    {
        return array_key_exists($input , $this->errors);
    }

    /**
     * Get Errors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Check If Empty Container Errors
     *
     * @return bool
     */
    public function passes()
    {
        return !empty($this->errors) ? false : true;
    }

    /**
     * Determine if the Given input is Not Empty
     *
     * @param $input
     * @param null $errorMessage
     * @return $this
     */
    public function required($input , $errorMessage = null)
    {
        if ($this->hasError($input)) {
            return $this;
        }

        $inputValue = $this->input->request($input, '');

        if ($inputValue === '') {

            $errorMessage = $errorMessage ?: sprintf('%s is required' , $input);

            $this->addError($input , $errorMessage);
        }

        return $this;
    }

    /**
     * Determine if the Given File input is Not Empty
     *
     * @param $input
     * @param null $errorMessage
     * @return $this
     */
    public function requiredFile($input , $errorMessage = null)
    {
        if ($this->hasError($input)) {
            return $this;
        }

        $inputValue = $this->input->file($input);

        if (!$inputValue->uploaded()) {

            $errorMessage = $errorMessage ?: sprintf('%s is required', $input);

            $this->addError($input , $errorMessage);
        }

        return $this;
    }

    /**
     * Determine if File Is Image
     *
     * @param $input
     * @param null $errorMessage
     * @return $this
     */
    public function isImage($input , $errorMessage = null)
    {
        if ($this->hasError($input)) {
            return $this;
        }

        $inputValue = $this->input->file($input);

        if ($inputValue->uploaded()) {

            if (!$inputValue->isImage()) {

                $errorMessage = $errorMessage ?: sprintf('%s is not valid image' , $input);

                $this->addError($input , $errorMessage);
            }
        }

        return $this;
    }

    /**
     * Determine if the given input is valid email
     *
     * @param $input
     * @param null $errorMessage
     * @return $this
     */
    public function email($input , $errorMessage = null)
    {
        if ($this->hasError($input)) {
            return $this;
        }

        $inputValue = $this->input->request($input);

        if (!filter_var($inputValue , FILTER_VALIDATE_EMAIL)) {

            $errorMessage = $errorMessage ?: sprintf('%s is not a valid email address' , $inputValue);

            $this->addError($input , $errorMessage);
        }

        return $this;
    }

    /**
     * Determine if the given input value should be at most the given length
     *
     * @param $input
     * @param $length
     * @param null $errorMessage
     * @return $this
     */
    public function max($input , $length , $errorMessage = null)
    {
        if ($this->hasError($input)) {
            return $this;
        }

        $inputValue = $this->input->request($input);

        if (strlen($inputValue) > $length) {

            $errorMessage = $errorMessage ?: sprintf('%s should be at least %d' , $inputValue , $length);

            $this->addError($input , $errorMessage);
        }

        return $this;
    }

    /**
     * Determine if the given input value should be at least the given length
     *
     * @param $input
     * @param $length
     * @param null $errorMessage
     * @return $this
     */
    public function min($input , $length , $errorMessage = null)
    {
        if ($this->hasError($input)) {
            return $this;
        }

        $inputValue = $this->input->request($input);

        if (strlen($inputValue) < $length) {

            $errorMessage = $errorMessage ?: sprintf('%s Should be at Most %d' , $inputValue , $length);

            $this->addError($input , $errorMessage);
        }

        return $this;
    }

    /**
     * Between Start -> ^
     * And End -> $
     * start input must by string ([a-z-A-Z])
     * of the string there has to be at least one number -> (?=.*\d)
     * and at least one letter -> (?=.*[A-Za-z])
     * and it has to be a number, a letter or one of the following: -> [0-9A-Za-z_]
     * and there have to be 8-16 characters -> {8,16}
     *
     *
     * @param $input
     * @param null $errorMessage
     * @return $this
     */
    public function username($input , $errorMessage = null)
    {
        if ($this->hasError($input)) {
            return $this;
        }

        $inputValue = $this->input->request($input);

        if (!preg_match('/^([a-zA-Z])(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z_]{8,16}$/' , $inputValue)) {

            $errorMessage = $errorMessage ?: sprintf('invalid username');

            $this->addError($input , $errorMessage);
        }

        return $this;
    }

    /**
     * Check If Value is Name
     * Allowed string and digits and whitespace
     *
     * @param $input
     * @param $errorMessage
     * @return mixed
     */
    public function name($input, $errorMessage = null)
    {
        if ($this->hasError($input)) {
            return $this;
        }

        $inputValue = $this->app->input->request($input);

        if (!preg_match('/^[a-zA-Z0-9 -]*$/', $inputValue)) {

            $errorMessage = $errorMessage ?: $input . ' invalid [only letters, numbers, space and dashes allowed]';

            $this->addError($input, $errorMessage);
        }

        return $this;
    }

    /**
     * Check If Value is Name Category
     * Allowed string, digits, whitespace, [#,@,!,*,/,\,+,.,&,^,-,_]
     *
     * @param $input
     * @param $errorMessage
     * @return mixed
     */
    public function specialName($input, $errorMessage = null)
    {
        if ($this->hasError($input)) {
            return $this;
        }

        $inputValue = $this->app->input->request($input);

        $pattern = '/^[a-zA-Z0-9 '.preg_quote( '.%^&()$#@!/-+_/,:', '/').']+$/';

        if (!preg_match($pattern, $inputValue)) {

            $errorMessage = $errorMessage ?: $input . ' invalid [only letters, numbers, space, dashes and [#@!*()\/+.&^,_"] allowed]';

            $this->addError($input, $errorMessage);
        }

        return $this;
    }

    /**
     * Checks if all of the characters in the provided string, text, are alphabetic
     *
     * @param $input
     * @param null $errorMessage
     * @return $this
     */
    public function alpha($input , $errorMessage = null)
    {
        if ($this->hasError($input)) {
            return $this;
        }

        $inputValue = $this->input->request($input);

        if (!ctype_alpha($inputValue)) {

            $errorMessage = $errorMessage ?: sprintf('%s allow only letters' , $input);

            $this->addError($input , $errorMessage);
        }

        return $this;
    }

    /**
     * Checks if all of the characters in the provided string, text, are alphanumeric
     * Returns TRUE if every character in text is either a letter or a digit, FALSE otherwise.
     *
     * @param $input
     * @param null $errorMessage
     * @return $this
     */
    public function alphaNum($input , $errorMessage = null)
    {
        if ($this->hasError($input)) {
            return $this;
        }

        $inputValue = $this->input->request($input);

        if (!ctype_alnum($inputValue)) {

            $errorMessage = $errorMessage ?: sprintf('%s allow only letters and digits' , $input);

            $this->addError($input , $errorMessage);
        }

        return $this;
    }


    /**
     * Find whether the type of a variable is integer
     *
     * @param $input
     * @param null $errorMessage
     * @return $this
     */
    public function int($input , $errorMessage = null)
    {
        if ($this->hasError($input)) {
            return $this;
        }

        $xInput = $this->input->request($input);

        $inputValue = is_numeric($xInput) ? (int)$xInput : null;

        if (!is_int($inputValue)) {

            $errorMessage = $errorMessage ?: sprintf('%s allowed only int' , $input);

            $this->addError($input , $errorMessage);
        }

        return $this;
    }

    /**
     * Finds whether a variable is a number or a numeric string
     *
     * @param $input
     * @param null $errorMessage
     * @return $this
     */
    public function number($input , $errorMessage = null)
    {
        if ($this->hasError($input)) {
            return $this;
        }

        $inputValue = $this->input->request($input);

        if (!is_numeric($inputValue)) {

            $errorMessage = $errorMessage ?: sprintf('%s allowed only numbers', $input);

            $this->addError($input, $errorMessage);
        }

        return $this;
    }


    /**
     * Checks the validity of the date
     *
     * @param $inputName
     * @param null $errorMessage
     * @return $this
     */
    public function date($inputName , $errorMessage = null)
    {
        if ($this->hasError($inputName)) {
            return $this;
        }

        $inputValue = $this->input->request($inputName);
        $split = [];

        if (preg_match('/^([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})$/' , $inputValue , $split)) {

            if (!checkdate($split[2] , $split[1] , $split[3])) {

                $errorMessage = $errorMessage ?: 'invalid format date';

                $this->addError($inputName , $errorMessage);
            }

        }else {

            $errorMessage = $errorMessage ?: 'invalid format date';

            $this->addError($inputName , $errorMessage);
        }

        return $this;
    }


    /**
     * Check requirement password :---
     * Must be 8-20 characters long
     * at least one lowercase char
     * at least one digit
     * at least one special sign of @#-_$%^&+=§!?
     * for be at least one uppercase char add this (?=.*[A-Z])
     *
     * @param $input
     * @param null $errorMessage
     * @return $this
     */
    public function password($input , $errorMessage = null)
    {
        if ($this->hasError($input)) {
            return $this;
        }

        $inputValue = $this->input->request($input);

        if (!preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/' , $inputValue)) {

            $errorMessage = $errorMessage ?: 'Password must be 8-20 characters contain of letters, numbers and at least one special character';

            $this->addError($input , $errorMessage);
        }

        return $this;
    }

    /**
     * Determine if the first input matches the second input
     *
     * @param $firstInput
     * @param $secondInput
     * @param null $errorMessage
     * @return $this
     */
    public function matches($firstInput , $secondInput , $errorMessage = null)
    {
        if ($this->hasError($firstInput)) {
            return $this;
        }

        $firstInputValue = $this->input->request($firstInput);
        $secondInputValue = $this->input->request($secondInput);

        if ($firstInputValue !== $secondInputValue) {

            $errorMessage = $errorMessage ?: sprintf('%s must matches %s' , $firstInput , $secondInput);

            $this->addError($firstInput , $errorMessage);
        }

        return $this;
    }

    /**
     * Determine if The Given input is Unique in Database
     *
     * @param $input
     * @param array $database
     * @param null $errorMessage
     * @return $this
     */
    public function unique($input , $database = [] , $errorMessage = null)
    {
        if ($this->hasError($input)) {
            return $this;
        }

        $inputValue = cleanInput($this->input->request($input));

        $table = '';
        $column = '';
        $exceptionColumn = '';
        $exceptionValue = '';

        if (count($database) == 4) {

            list($table , $column , $exceptionColumn , $exceptionValue) = $database;

            $result = $this->app->db->select($column , $exceptionColumn)->from($table)
                ->where(sprintf('`%s` = ? AND `%s` != ?' , $column , $exceptionColumn) , $inputValue , $exceptionValue)
                ->fetch();
        }else {

            list($table , $column) = $database;

            $result = $this->app->db->select($column)->from($table)
                ->where(sprintf('%s = ?' , $column) , $inputValue)
                ->fetch();
        }

        if ($result) {

            $errorMessage = $errorMessage ?: sprintf('%s already exists' , $input);

            $this->addError($input , $errorMessage);
        }

        return $this;
    }

    /**
     * Check If Value is one or zero
     *
     * @param $input
     * @param $errorMessage
     * @return mixed
     */
    public function isOneOrZero($input, $errorMessage = null)
    {
        if ($this->hasError($input)) {
            return $this;
        }

        $value = $this->app->input->request($input);

        $inputValue = is_numeric($value) ? (int)$value : null;

        if (($inputValue !== 0) && ($inputValue !== 1)) {

            $errorMessage = $errorMessage ?: sprintf('%s invalid', $input);

            $this->addError($input, $errorMessage);
        }

        return $this;
    }

    /**
     * Magic method get
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->app->$name;
    }

}
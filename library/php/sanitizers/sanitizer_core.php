<?php

class sanitizer_core {

    public static function defaulted($array, $value, $type, $default) {
        $return = null;
        if (array_key_exists($value, $array) === true) {
            $return = self::value($array[$value], $type);
        }
        if (is_null($return) === true) {
            $return = $default;
        }
        return $return;
    }

    public static function value($value, $type) {
        $return = null;
        $filter = null;
        switch ($type) {
            case cst_sanitizer::sane_boolean:
                $filter  = FILTER_VALIDATE_BOOLEAN;
                $options = array('options' => array('default' => null));
                break;
            case cst_sanitizer::sane_email:
                $filter  = FILTER_VALIDATE_EMAIL;
                $options = array('options' => array('default' => null));
                break;
            case cst_sanitizer::sane_string:
                $filter  = FILTER_SANITIZE_STRING;
                $value = str_replace('../', '', $value);
                $options = array('options' => array('default' => null));
                break;
            case cst_sanitizer::sane_integer:
                $filter  = FILTER_VALIDATE_INT;
                $options = array('options' => array('default' => null));
                break;
            case cst_sanitizer::sane_float:
                $filter  = FILTER_VALIDATE_FLOAT;
                $options = array('options' => array('default' => null));
                break;
            case cst_sanitizer::sane_date:
                $filter  = FILTER_VALIDATE_REGEXP;
                $options = array('options' => array(
                        'default' => null,
                        'regexp'  => '/^201[3-9]-[0-1][0-9]-[0-3][0-9]$/'));
                break;
            case cst_sanitizer::sane_datetime:
                $filter  = FILTER_VALIDATE_REGEXP;
                $options = array('options' => array(
                        'default' => null,
                        'regexp'  => '/^201[3-9]-[0-1][0-9]-[0-3][0-9] [0-2][0-9]:[0-5][0-9]:[0-5][0-9]$/'));
                break;
        }
        if (is_null($filter) === false) {
            $return = filter_var($value, $filter, $options);
            if ($return != $value) {
                $return = null;
            }
        }
        return $return;
    }

}

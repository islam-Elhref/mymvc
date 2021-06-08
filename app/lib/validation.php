<?php


namespace MYMVC\LIB;


use VARIANT;

trait Validation
{

// req
// num
//int
// float
//alpha
//alphanum

    private $_regexpatterns = [
        'num' => '/^[0-9]+(?:\.[0-9]+)?$/',
        'int' => '/^[0-9]+$/',
        'float' => '/^[0-9]+\.[0-9]+$/',
        'alpha' => '/^[a-zA-Z\p{Arabic}]+$/u',
        'alphaEn' => '/^[a-zA-Z]+$/u',
        'alphanum' => '/^[a-zA-Z\p{Arabic}0-9]+$/u',
        'alphanumEn' => '/^[a-zA-Z0-9]+$/u',
        'vdate' => '/^[1-2][0-9][0-9][0-9]-(?:(?:0[1-9])|(?:1[0-2]))-(?:(?:0[1-9])|(?:1[0-9])|(?:2[0-9])|(?:3[0-1]))/',
        'vemail' => '/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i'
    ];

    public function req($value)
    {
        return !empty($value) || $value != '';
    }

    public function num($value)
    {
        return (bool)preg_match($this->_regexpatterns['num'], $value);
    }

    public function int($value)
    {
        return (bool)preg_match($this->_regexpatterns['int'], $value);
    }

    public function float($value)
    {
        return (bool)preg_match($this->_regexpatterns['float'], $value);
    }

    public function alpha($value)
    {
        return (bool)preg_match($this->_regexpatterns['alpha'], $value);
    }

    public function alphaEn($value)
    {
        return (bool)preg_match($this->_regexpatterns['alphaEn'], $value);
    }

    public function alphanum($value)
    {
        return (bool)preg_match($this->_regexpatterns['alphanum'], $value);
    }

    public function alphanumEn($value)
    {
        return (bool)preg_match($this->_regexpatterns['alphanumEn'], $value);
    }

    public function lt($value, $num)
    {
        if (is_numeric($value)) {
            return $value < $num;
        } elseif (is_string($value)) {
            return mb_strlen($value, 'utf-8') < $num;
        }
    }

    public function gt($value, $num)
    {
        if (is_numeric($value)) {
            return $value > $num;
        } elseif (is_string($value)) {
            return mb_strlen($value, 'utf-8') > $num;
        }
    }

    public function min($value, $min)
    {
        return $value >= $min;
    }

    public function max($value, $max)
    {
        return $value <= $max;
    }

    public function smin($value, $min)
    {
        return mb_strlen($value, 'utf-8') >= $min;
    }

    public function smax($value, $max)
    {
        return mb_strlen($value, 'utf-8') <= $max;

    }

    public function between($value, $min, $max)
    {
        $temp_min = ($min <= $max) ? $min : $max;
        $temp_max = ($min <= $max) ? $max : $min;
        if (is_numeric($value)) {
            return $value >= $temp_min && $value <= $temp_max;
        } elseif (is_string($value)) {
            return mb_strlen($value, 'utf-8') >= $temp_min && mb_strlen($value, 'utf-8') <= $temp_max;
        }
    }

    public function vdate($date)
    {
        return (bool)preg_match($this->_regexpatterns['vdate'], $date);
    }

    public function myvdate($date)
    {
        $first_check = date_parse($date);
        if ($first_check['year'] != false || $first_check['day'] != false || $first_check['month'] != false) {
            $arr_date = explode('-', $date);
            $year = $arr_date[0];
            $month = (strlen($arr_date[1]) < 2) ? 0 . $arr_date[1] : $arr_date[1];
            $day = (strlen($arr_date[2]) < 2) ? 0 . $arr_date[2] : $arr_date[2];
            $first_valid = checkdate($month, $day, $year);
            if ($first_valid) {
                $tempDate = $year . '-' . $month . '-' . $day;
                return $this->vdate($tempDate);
            }
        }

        return false;
    }

    public function vemail($value)
    {
        return (bool)preg_match($this->_regexpatterns['vemail'], $value);
    }

    public function url($value)
    {
        return (bool)filter_var($value, FILTER_VALIDATE_URL);
    }

    //preg_match('/\w+\((\d+)\)/', 'islam min(55)' , $m);

    public function is_valid($rules, array $input_type)
    {

        $error = [];
        $lang =  $this->_language->getDictionary();

        foreach ($rules as $input => $rule_input) {
            $rule_input = explode('|', $rule_input);

            if (isset($input_type[$input])) {
                $value = $input_type[$input];
            } else {
                $value = '';
            }

            foreach ($rule_input as $rule) {
                if (preg_match('/(\w+)\((\d+)\)/', $rule, $m)) {
                    $temp = $m[1];
                    if (!$this->$temp($value, $m[2])) {
                        $error[] = $input . ' ' . $rule;
                        $this->_msg->addmsg($lang['msg_'.$input.'_'. $m[1]] , Messenger::Msg_error , $input);
                    }

                } elseif (preg_match('/\w+/', $rule, $m)) {
                    if (!$this->{$rule}($value)) {
                        $error[] = $input . ' ' . $rule;
                        $this->_msg->addmsg($lang['msg_'.$input.'_'. $m[0]] , Messenger::Msg_error , $input);
                    }
                }
            }
        }
        return empty($error) ? true : false;
    }


}
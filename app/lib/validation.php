<?php


namespace MYMVC\LIB;


use VARIANT;

trait Validation
{

    private $_regexpatterns = [
        'num' => '/^[0-9]+(?:\.[0-9]+)?$/',
        'int' => '/^[0-9]+$/',
        'float' => '/^[0-9]+\.[0-9]+$/',
        'alpha' => '/^[a-zA-Z\p{Arabic} ]+$/u',
        'alphaEn' => '/^[a-zA-Z]+$/u',
        'alphanum' => '/^[a-zA-Z\p{Arabic}0-9 ]+$/u',
        'alphanumEn' => '/^[a-zA-Z0-9]+$/u',
        'vdate' => '/^[1-2][0-9][0-9][0-9]-(?:(?:0[1-9])|(?:1[0-2]))-(?:(?:0[1-9])|(?:1[0-9])|(?:2[0-9])|(?:3[0-1]))/',
        'vemail' => '/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i',
        'url_privilege' => '/^\/[a-z]+[\/]?[a-z]*$/',
        'phone' => '/^01[0-9]{9}$/',
    ];

    public function req($value)
    {
        if (is_array($value) && isset($value['name'])) {
            if ($value['name'] == '' && $value['type'] == '' && $value['tmp_name'] == '') {
                return false;
            }
        }
        return !empty($value) || $value != '';
    }

    public function image_ext($value)
    {

            if ($value['name'] == '' && $value['type'] == '' && $value['tmp_name'] == '') {
                return true;
            } else {
                $image = new UploadFile($value);

                if ($image->isallowedtype()) {
                    return true;
                } else {
                    $this->_msg->addMsg($this->_language->feed_msg("msg_error_image_ext_array", [$image->printAllow_extentions()]), Messenger::Msg_error);
                    return false;
                }
            }
    }

    public function image_size($value)
    {
        if ($value['name'] == '' && $value['type'] == '' && $value['tmp_name'] == '') {
            return true;
        } else {
            $image = new UploadFile($value);
            if ($image->isSizeAcceptable()) {
                return true;
            } else {
                $this->_msg->addMsg($this->_language->feed_msg("msg_error_image_max_size", [$image->printmaxFileSize()]), Messenger::Msg_error);
                return false;
            }
        }
    }

    public function phone($value)
    {
        if ($value != null) {
            return (bool)preg_match($this->_regexpatterns['phone'], $value);
        }
        return true;
    }

    public function num($value)
    {
        if ($value != null) {
            return (bool)preg_match($this->_regexpatterns['num'], $value);
        }
        return true;
    }

    public function int($value)
    {

        if ($value != null) {
            if (is_array($value)){
                foreach ($value as $val){
                    return (bool)preg_match($this->_regexpatterns['int'], $val);
                }
            }else{
                return (bool)preg_match($this->_regexpatterns['int'], $value);
            }
        }
        return true;
    }

    public function float($value)
    {
        if ($value != null) {
            return (bool)preg_match($this->_regexpatterns['float'], $value);
        }
        return true;
    }

    public function alpha($value)
    {
        if ($value != null) {
            return (bool)preg_match($this->_regexpatterns['alpha'], $value);
        }
        return true;
    }

    public function alphaEn($value)
    {
        if ($value != null) {
            return (bool)preg_match($this->_regexpatterns['alphaEn'], $value);
        }
        return true;
    }

    public function alphanum($value)
    {
        if ($value != null) {
            return (bool)preg_match($this->_regexpatterns['alphanum'], $value);
        }
        return true;
    }

    public function alphanumEn($value)
    {
        if ($value != null) {
            return (bool)preg_match($this->_regexpatterns['alphanumEn'], $value);
        }
        return true;
    }

    public function lt($value, $num)
    {
        if (is_string($value)) {
            return mb_strlen($value, 'utf-8') < $num;
        } elseif (is_numeric($value)) {
            return $value < $num;
        }

    }

    public function gt($value, $num)
    {
        if (is_string($value)) {
            return mb_strlen($value, 'utf-8') > $num;
        } elseif (is_numeric($value)) {
            return $value > $num;
        }
    }

    public function eq($value, $match_aginste)
    {
        return $value == $match_aginste;
    }

    public function eqinput($value, $other_input)
    {
        return $value == $other_input;
    }

    public function min($value, $min)
    {
        return $value >= $min;
    }

    public function smin($value, $min)
    {
        return mb_strlen($value, 'utf-8') >= $min;
    }

    public function max($value, $max)
    {
        return $value <= $max;
    }

    public function smax($value, $max)
    {
        return mb_strlen($value, 'utf-8') <= $max;

    }

    public function between($value, $min, $max)
    {
        if ($value != null) {
            $temp_min = ($min <= $max) ? $min : $max;
            $temp_max = ($min <= $max) ? $max : $min;
            return $value >= $temp_min && $value <= $temp_max;
        }
        return true;
    }

    public function sbetween($value, $min, $max)
    {
        if ($value != null) {
            $temp_min = ($min <= $max) ? $min : $max;
            $temp_max = ($min <= $max) ? $max : $min;
            return mb_strlen($value, 'utf-8') >= $temp_min && mb_strlen($value, 'utf-8') <= $temp_max;
        }
        return true;
    }

    public function vdate($date)
    {
        return (bool)preg_match($this->_regexpatterns['vdate'], $date);
    }

    public function myvdate($date)
    {
        if ($date != null) {
            $first_check = date_parse($date);
            if ($first_check['year'] != false || $first_check['day'] != false || $first_check['month'] != false) {
                $arr_date = explode('-', $date);
                $year = $first_check['year'];
                $month = (strlen($first_check['month']) < 2) ? 0 . $first_check['month'] : $first_check['month'];
                $day = (strlen($first_check['day']) < 2) ? 0 . $first_check['day'] : $first_check['day'];
                $first_valid = checkdate($month, $day, $year);
                if ($first_valid) {
                    $tempDate = $year . '-' . $month . '-' . $day;
                    return $this->vdate($tempDate);
                }
            }
            return false;

        }
        return true;
    }

    public
    function vemail($value)
    {
        return (bool)preg_match($this->_regexpatterns['vemail'], $value);
    }

    public
    function url($value)
    {
        return (bool)filter_var($value, FILTER_VALIDATE_URL);
    }

    function url_privilege($value)
    {
        return (bool)preg_match($this->_regexpatterns['url_privilege'], $value);
    }


    public
    function is_valid($rules_to_valid, $inputs)
    {
        $error = [];
        foreach ($rules_to_valid as $input => $rules) {

            $rules = explode('|', $rules);

            if (empty($_FILES[$input])) {
                $value = isset($inputs[$input]) ? $inputs[$input] : null;
            } else {
                $value = isset($_FILES[$input]) ? $_FILES[$input] : null;
            }

            foreach ($rules as $rule) {

                if (preg_match('/^\w+$/', $rule)) {

                    if ($this->{$rule}($value) == false) {
                        $this->_msg->addMsg($this->_language->feed_msg("msg_error_$rule", ["Text_label_$input"]), Messenger::Msg_error);
                        $error[] = 'error';
                        break;
                    }
                } elseif (preg_match('/^(\w+)\((\d+|\w+)\)$/', $rule, $m)) {
                    $rule = $m[1];
                    $other_value = $rule == 'eqinput' ? $inputs[$m[2]] : $m[2];
                    $label = $rule == 'eqinput' ? $this->_language->get("Text_label_$m[2]") : $m[2];

                    if ($this->{$rule}($value, $other_value) == false) {
                        $this->_msg->addMsg($this->_language->feed_msg('msg_error_' . $rule, ["Text_label_$input", $label]), Messenger::Msg_error);
                        $error[] = 'error';
                        break;
                    }
                } elseif (preg_match('/^(\w+)\((\d+)\,(\d+)\)$/', $rule, $m)) {
                    $rule = $m[1];
                    if ($this->{$rule}($value, $m[2], $m[3]) == false) {
                        $this->_msg->addMsg($this->_language->feed_msg("msg_error_$rule", ["Text_label_$input", $m[2], $m[3]]), Messenger::Msg_error);
                        $error[] = 'error';
                        break;
                    }
                }

            }
        }

        return empty($error) ? true : false;

    }


}
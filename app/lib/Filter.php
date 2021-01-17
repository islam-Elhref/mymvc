<?php


namespace MYMVC\LIB;


trait filter
{

    public function filterInt($input)
    {
        return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
    }

    public function filterFloat($input)
    {
        return filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }

    public function filterString($input)
    {
        $input = htmlspecialchars(strip_tags($input), ENT_QUOTES, 'UTF-8');
        return filter_var($input, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    public function filterEmail($input)
    {
        return filter_var($input, FILTER_SANITIZE_EMAIL);
    }

}
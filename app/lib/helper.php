<?php


namespace MYMVC\LIB;


trait Helper
{

    public function redirect($path)
    {
        session_write_close();
        header('Location: ' . $path);
        exit();
    }

    public function write_msg(string $ar_msg , string $en_msg)
    {
        $lang = $_SESSION['lang'];
        if ($lang === 'ar') {
            $_SESSION['message'] = $ar_msg ;
        } else {
            $_SESSION['message'] = $en_msg;
        }
    }

}
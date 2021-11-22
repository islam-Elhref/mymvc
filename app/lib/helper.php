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

    public function redirect_back()
    {
        $link = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
        $this->redirect($link);
    }

}
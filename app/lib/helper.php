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

    public function write_msg(string $ar_msg , string $en_msg , $type)
    {
        $lang = $_SESSION['lang'];
        if ($lang === 'ar') {
            $this->_msg->addMsg($ar_msg , $type);
        } else {
            $this->_msg->addMsg($en_msg , $type);
        }
    }

}
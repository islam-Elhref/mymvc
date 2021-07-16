<?php


namespace MYMVC\LIB;


class Authantcation
{
    private $session;
    private static $_instance ;

    private function __construct($session){
        $this->session = $session;
    }
    private function __clone(){}

    /**
     * @return mixed
     */
    public static function getInstance($session)
    {
        if (self::$_instance == null){
            self::$_instance = new self($session);
        }

        return self::$_instance;
    }

    public function is_authantcate(){
        if(isset($this->session->u) && $this->session->u != ''){
            return 1 ;
        }
        return false;
    }

}
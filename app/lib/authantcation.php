<?php


namespace MYMVC\LIB;


use MYMVC\MODELS\UsersModel;

class Authantcation
{
    use Helper;

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
            $user = UsersModel::getonetest(['user_id' => $this->session->u->getUserId() ]);
            if ($user->getStatus() == 1 ){
                return 1 ;
            }else{
                $this->session->kill();
                if (isset($_COOKIE['remember'])) {
                    unset($_COOKIE['remember']);
                    setcookie('remember', null, -1, '/');
                }
                $this->redirect('/');
                return false;
            }
        }
        return false;
    }

}
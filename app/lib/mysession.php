<?php

namespace MYMVC\LIB;


use MYMVC\MODELS\UsersModel;
use SessionHandler;

class MySession extends SessionHandler
{

    use openssl;

    private $session_name = Session_Name;
    private $lifetime = SESSION_LIFETIME;
    private $session_secure = false;
    private $session_httponly = true;
    private $session_path = '/';
    private $session_domain = Session_Domain;
    private $session_save_path = SESSION_PATH;
    private $time_end_session = 1;


    public function __construct()
    {

        session_name($this->session_name);
        ini_set('session.use_cookies', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.use_trans_sid', 0);
        ini_set('session.save_handler', 'files');

        session_save_path($this->session_save_path);
        session_set_cookie_params(
            $this->lifetime,
            $this->session_path,
            $this->session_domain,
            $this->session_secure,
            $this->session_httponly
        );

        session_set_save_handler($this, true);

    }


    public function read($id)
    {
        $data = parent::read($id);

        if (!$data) {
            return "";
        } else {
            return $this->session_decrypt($data);
        }
    }

    public function write($id, $data)
    {
        $data_enc = $this->session_encrypt($data);

        return parent::write($id, $data_enc);
    }

    protected function getsession(): MySession{
        return $this->_sessions;
    }

    public function __set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function __get($name)
    {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : exit();
    }


    public function __isset($name)
    {
        // TODO: Implement __isset() method.
        return isset($_SESSION[$name]) ? true : false;
    }

    public function __unset($name)
    {
        if (isset($name)) {
            unset($_SESSION[$name]);
        }
    }

    public function kill()
    {
        session_unset();
        session_destroy();
        setcookie(
            $this->session_name, '', time() - 1000,
            $this->session_path, $this->session_domain,
            $this->session_secure, $this->session_httponly
        );

    }

    private function makeFingerPrint()
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $session_id = session_id();
        $this->PrintKey = openssl_random_pseudo_bytes(32);
        $this->fingerPrint = sha1($userAgent . $this->PrintKey . $session_id);
    }

    private function checkFingerPrint()
    {

        if (!isset($this->fingerPrint)) {
            $this->makeFingerPrint();
        } else {
            $userAgent = $_SERVER['HTTP_USER_AGENT'];
            $session_id = session_id();
            if (!hash_equals($this->fingerPrint, sha1($userAgent . $this->PrintKey . $session_id))) {
                var_dump($this->fingerPrint , sha1($userAgent . $this->PrintKey . $session_id) ); exit();
                $this->kill();
            }
        }
    }

    private function renew_session()
    {

        if (date('i', time() - $this->start_time) >= $this->time_end_session) {
            session_regenerate_id(true);
            $this->start_time = time();
            $this->makeFingerPrint();

        }
    }

    public function start()
    {
        if (session_id() === '') {
            if (session_start()) {
                if (!isset($this->start_time)) {
                    $this->start_time = time();
                    $this->user_time = time();
                } else {
                    $this->renew_session();
                }
                $this->checkFingerPrint();
            }
        }
    }

    public function checkUserTime(){
        if (date('i', time() - $this->user_time) >= 1) {
            $this->user_time = time();
            return true ;
        }
        return false ;
    }

    /**
     * @return UsersModel;
     */
    public function getuser (){
        return isset($this->u) ? $this->u : false ;
    }

}


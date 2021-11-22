<?php


namespace MYMVC\LIB;


use MYMVC\MODELS\UsersModel;

class Authantcation
{
    use Helper;

    /**
     * @var MySession
     */
    private $session;
    private static $_instance;
    private $default_routes = [
        '/index/default',
        '/auth/logout',
        '/auth/login',
        '/users/changepass',
        '/usersprofile/edit',
        '/language/default',
        '/notification/default',
        '/accessdenied/default',
        '/notfound/notfound',
        '/suppliers/supplierexist',
        '/clients/supplierexist',
        '/users/userexist',
        '/receiptspurchases/get_price',
        '/receiptssales/get_price',
    ];

    private function __construct($session)
    {
        $this->session = $session;
    }

    private function __clone()
    {
    }

    /**
     * @return mixed
     */
    public static function getInstance($session)
    {
        if (self::$_instance == null) {
            self::$_instance = new self($session);
        }

        return self::$_instance;
    }

    private function checkcookie()
    {

        if (isset($_COOKIE['remember']) && $_COOKIE['remember'] != '') {
            $array = unserialize($_COOKIE['remember']);
            $username = $array['username'];
            $password = $array['password'];

            try {
                $olduser = UsersModel::getuser(['username' => $username]);
                if (!empty($olduser)) {

                    if ($olduser->checkPassword($password)) {

                        if ($olduser->getStatus() == 1) {
                            $olduser->setLastLogin(date('Y-m-d h:i:s'));
                            $olduser->save();
                            $olduser->user_save_in_session_wzout_pass($olduser, $this->session);
                            $link = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
                            $this->redirect($link);
                        } elseif ($olduser->getStatus() == 3) {
                            $this->session->profile = $olduser->getUserId();
                        }

                    }
                }
            } catch (\PDOException $e) {

            }
        }
    }

    public function is_authantcate()
    {

        if (isset($this->session->u) && $this->session->u != '') {
            if ($this->session->checkUserTime()) {
                $user = UsersModel::getuser(['user_id' => $this->session->u->getUserId()]);
                $user->user_save_in_session_wzout_pass($user, $this->session);
            } //check user after 5 min
            if ($this->session->u->getStatus() == 1) { // if status = 1 return 1 if not kill session and kill cookie remember
                return 1;
            } else {
                $this->session->kill();
                if (isset($_COOKIE['remember'])) {
                    unset($_COOKIE['remember']);
                    setcookie('remember', null, -1, '/');
                }

                $this->redirect('/');

                return false ;
            }
        } else {
            $this->checkcookie();
            if (isset($this->session->profile) | ($this->session->getuser() != false && $this->session->getuser()->setStatus() == 3 )  ) { // if there session profile return 3
                return 3;
            }
        }
        return false;
    }

    public function hasAccess($controler, $action)
    {
        $url = strtolower('/' . $controler . '/' . $action);
        if (isset($this->session->u) && $this->session->u != '') {
            $route_privileges = array_merge($this->default_routes, $this->session->u->getPrivileges());
            if (in_array($url, $route_privileges)) {
                return true;
            }else{
                return false;
            }
        } else {
            return true;
        }
    }


}
<?php


namespace MYMVC\LIB;


use MYMVC\MODELS\UsersModel;

class Authantcation
{
    use Helper;

    private $session;
    private static $_instance;

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
                $olduser = UsersModel::getonetest(['username' => $username]);
                if (!empty($olduser)) {

                    if ($olduser->getPassword() === $password) {
                        if ($olduser->getStatus() == 1) {
                            $olduser->setLastLogin(date('Y-m-d h:i:s'));
                            $olduser->save();
                            $olduser->user_save_in_session_wzout_pass($olduser, $this->session);

                            $link = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
                            $this->redirect($link);
                        }elseif ($olduser->getStatus() == 3){
                            $this->getmsg()->addMsg($this->getLang()->feed_msg('msg_user_profile', [$username]), Messenger::Msg_error);
                            $this->getsession()->profile = $olduser->getUserId();
                            $this->redirect('/usersprofile/add');
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
                $user = UsersModel::getonetest(['user_id' => $this->session->u->getUserId()]);
                $user->user_save_in_session_wzout_pass($user, $this->session);
            }
            if ($this->session->u->getStatus() == 1) {
                return 1;
            } else {
                $this->session->kill();
                if (isset($_COOKIE['remember'])) {
                    unset($_COOKIE['remember']);
                    setcookie('remember', null, -1, '/');
                }

                $this->redirect('/');
                return false;
            }
        } else {
            $this->checkcookie();
            if (isset($this->session->profile)) {
                return 3;
            }
        }
        return false;
    }

}
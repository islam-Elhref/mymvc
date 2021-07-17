<?php


namespace MYMVC\CONTROLLERS;


use MYMVC\LIB\filter;
use MYMVC\LIB\Helper;
use MYMVC\LIB\Language;
use MYMVC\LIB\Messenger;
use MYMVC\MODELS\UsersModel;

class AuthController extends AbstractController
{
    use filter;
    use Helper;

    private function checkcookie()
    {
        if (isset($_COOKIE['remember']) && $_COOKIE['remember'] != '') {
            $array = unserialize($_COOKIE['remember']);
            $username = $array['username'];
            $password = $array['password'];

            try {
                $olduser = UsersModel::getonetest(['username' => $username]);
                if (!empty($olduser)) {
                    if ($olduser->getStatus() == 1) {

                        if ($olduser->getPassword() === $password) {

                            $olduser->setLastLogin(date('Y-m-d h:i:s'));
                            $olduser->save();
                            $olduser->user_save_in_session_wzout_pass($olduser , $this->getsession() );

                            $link = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
                            $this->redirect($link);
                        }

                    } elseif ($olduser->getStatus() == 2) {
                        $this->getmsg()->addMsg($this->getLang()->feed_msg('msg_user_disabled', [$username]), Messenger::Msg_error);
                    }
                }
            } catch (\PDOException $e) {

            }
        }
    }

    public function loginAction()
    {
        $this->checkcookie();
        if (!isset($this->getsession()->u)) {
            $view = array_intersect([':view' => 'view'], $this->_template->getTemplate());
            $header_resources = str_replace(['main_ar', 'main_en'], ['login_ar', 'login_en'], $this->_template->getHeader_resources());
            $this->_template->changeTemplate($view);
            $this->_template->changeHeaderResources($header_resources);

            $this->getLang()->load('auth', 'login');
            $this->getLang()->load('auth', 'label');
            $this->getLang()->load('auth', 'msgs');


            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
                $username = $this->filterString($_POST['username']);
                $password = $_POST['password'];
                try {
                    $user = UsersModel::getonetest(['username' => $username]);
                    if (!empty($user)) {
                        if ($user->getStatus() == 1) {


                            if ($user->checkPassword($password)) {
                                if (isset($_POST['remember'])) { // generate cookie remember
                                    $array = ['username' => $username, 'password' => $user->getPassword()];
                                    setcookie('remember', serialize($array), (time() + (86400 * 30)), '/');
                                } else { // delete cookie
                                    if (isset($_COOKIE['remember'])) {
                                        unset($_COOKIE['remember']);
                                        setcookie('remember', null, -1, '/');
                                    }
                                } // generate or delete cookie

                                $user->setLastLogin(date('Y-m-d h:i:s'));
                                $user->save();
                                $user->user_save_in_session_wzout_pass($user , $this->getsession());
                                $this->getmsg()->addMsg($this->getLang()->feed_msg('msg_success', [$username]), Messenger::Msg_success);

                                $link = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
                                $this->redirect($link);

                            } else {
                                throw new \PDOException($this->getLang()->get('msg_failed_password'));
                            }
                        }elseif ($user->getStatus() == 2){
                            $this->getmsg()->addMsg($this->getLang()->feed_msg('msg_user_disabled', [$username]), Messenger::Msg_error);
                        }
                    } else { // اذا كان اسم المستخدم غير صحيح
                        throw new \PDOException($this->getLang()->get('msg_failed_username'));
                    }
                } catch (\PDOException $e) {
                    $this->getmsg()->addMsg($e->getMessage(), Messenger::Msg_error);
                }

            }
            $this->view();
        } else {
            $this->redirect('/');
        }
    }


    public function logoutAction()
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->getsession()->kill();
            if (isset($_COOKIE['remember'])) {
                unset($_COOKIE['remember']);
                setcookie('remember', null, -1, '/');
            }
            if ($_SERVER['HTTP_REFERER'] == 'http://mymvc.com/auth/logout') {
                $link = '/';
            } else {
                $link = $_SERVER['HTTP_REFERER'];
            }
            $this->redirect($link);
        } else {
            $this->redirect('/');
        }
    }

}
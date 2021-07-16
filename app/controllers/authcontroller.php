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


    public function loginAction()
    {
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
//                $user = UsersModel::getUser(['username' => $username]);
                $user= UsersModel::getonetest(['username' => $username]);
                if (!empty($user)){

                    if ($user->checkPassword($password)){
                            $user_with_out_Pass = $user ;
                            $user_with_out_Pass->removePassword();

                        $this->getsession()->u = $user_with_out_Pass ;
                        $this->redirect($_SERVER['HTTP_REFERER']);
                    }else{
                        throw new \PDOException($this->getLang()->get('msg_failed_password'));
                    }
                }else{ // اذا كان اسم المستخدم غير صحيح
                    throw new \PDOException($this->getLang()->get('msg_failed_username'));
                }
            }catch (\PDOException $e){
                $this->getmsg()->addMsg($e->getMessage() , Messenger::Msg_error);
                $this->redirect('/index');
            }

        }


        $this->view();
    }

}
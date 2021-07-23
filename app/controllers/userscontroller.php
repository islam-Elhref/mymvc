<?php


namespace MYMVC\CONTROLLERS;


use http\Header;
use MYMVC\LIB\filter;
use MYMVC\LIB\Helper;
use MYMVC\LIB\Messenger;
use MYMVC\MODELS\UsersGroupsModel;
use MYMVC\MODELS\UsersModel;
use PDOException;

class usersController extends AbstractController
{
    use Helper;
    use filter;

    private $rules_to_valid = [
        'Username' => 'req|alphanumEn|sbetween(4,20)',
        'Password' => 'req|sbetween(6,20)',
        'CPassword' => "req|sbetween(6,20)|eqinput(Password)",
        'Email' => 'req|vemail',
        'CEmail' => 'req|vemail|eqinput(Email)',
        'Phone' => 'int',
        'group_id' => 'req|int'
    ];
    private $lang;

    public function defaultAction()
    {
        $this->_language->load('users', 'default');
        $this->_data['users'] = UsersModel::usersgetAll($this->getsession()->u);
        $this->view();
    }

    public function addAction()
    {
        $this->_language->load('users', 'label');
        $this->_language->load('users', 'add');
        $this->_language->load('users', 'msgs');
        $this->_language->load('validation', 'errors');

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']) && $this->is_valid($this->rules_to_valid, $_POST) == true) {
            $user = new UsersModel($_POST['Username'], UsersModel::cryptPassword($_POST['Password']), $_POST['Email'], $_POST['Phone'], $_POST['group_id']);
            try {
                $user->save();
                $this->_msg->addMsg($this->_language->feed_msg('msg_success_add', [$user->getUsername()]), Messenger::Msg_success);
            } catch (PDOException $e) {
                $this->_msg->addMsg($this->_language->feed_msg('msg_error', [$e->getMessage()]), Messenger::Msg_error);
            }
            $this->redirect('/users');
        }

        $this->_data['groups'] = UsersGroupsModel::getAll();
        $this->view();
    }

    public function editAction()
    {
        $id = isset($this->_params[0]) ? $this->filterInt($this->_params[0]) : '';
        $user = UsersModel::getByPK($id);
        $olduser = clone $user;
        if ($user != false  && isset($_SERVER['HTTP_REFERER']) && $user->getUserId() != $this->getsession()->u->getUserId() ) {
            $this->_language->load('users', 'edit'); // language edit
            $this->_language->load('users', 'label'); // language label input
            $this->_language->load('users', 'msgs'); // language for msgs success and faild
            $this->_language->load('validation', 'errors'); // langauge for validation error in same page

            $this->rules_to_valid['Password'] = 'sbetween(6,20)'; //change rule for Password make it not required
            $this->rules_to_valid['CPassword'] = 'sbetween(6,20)|eqinput(Password)'; //change rule for Password make it not required


            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']) && $this->is_valid($this->rules_to_valid, $_POST) == true) {

                $password = $_POST['Password'] == '' ? $user->getPassword() : UsersModel::cryptPassword($_POST['Password']);
                $user_edit = $user->edit_action_construct($_POST['Username'], $password, $_POST['Email'], $_POST['Phone'], $_POST['group_id']);
                $user_edit->setUserId($user->getUserId());
                try {
                    $user_edit->save();
                    if ($olduser->getUsername() == $_POST['Username']) {
                        $this->_msg->addMsg($this->_language->feed_msg('msg_success_edit', [$user->getUsername()]), Messenger::Msg_success);
                    } else {
                        $this->_msg->addMsg($this->_language->feed_msg('msg_success_edit_user', [$olduser->getUsername(), $_POST['Username']]), Messenger::Msg_success);
                    }

                } catch (PDOException $e) {
                    $this->_msg->addMsg($this->_language->feed_msg('msg_error_edit', [$e->getMessage()]), Messenger::Msg_error);
                }
                $this->redirect('/users');
            }


            $this->_data['userActive'] = $user;
            $this->_data['groups'] = UsersGroupsModel::getAll();
            $this->view();
        } else {
            $this->redirect('/users');
        }
    }

    public function deleteAction()
    {
        if (isset($this->_params[0]) && is_numeric($this->_params[0]) && isset($_SERVER['HTTP_REFERER'])) {
            $user_id = $this->filterInt($this->_params[0]);
            $user = UsersModel::getByPK($user_id);
            $this->getLang()->load('users', 'msgs');

            if (!empty($user) && $user->getUserId() != $this->getsession()->u->getUserId()) {
                try {
                    $user->delete();
                    $msg = $this->getLang()->feed_msg('msg_success_delete', [$user->getUsername()]);
                    $this->getmsg()->addMsg($msg, Messenger::Msg_success);
                } catch (PDOException $e) {
                    $msg = $this->getLang()->get('msg_error_delete');
                    $this->getmsg()->addMsg($msg, Messenger::Msg_error);
                }
            }
            $this->redirect('/users');
        } else {
            $this->redirect('/users');
        }
    }

    public function userexistAction()
    {

        // $_post['input'] دي بس بتديني اسم الانبوت
        // $_post[$_post[input]]   ادي بتديني القيمه بتاعة الانبوت اللي جبته من الكود السابق

        if (isset($_POST[$_POST['input']])) {
            header('content-type: text/plain');
            $user = UsersModel::getone(["$_POST[input]" => $this->filterString($_POST[$_POST['input']])]);
            if (is_object($user) && !empty($user)) {
                echo 1;
            } else {
                echo 0;
            }
        }

    }


}
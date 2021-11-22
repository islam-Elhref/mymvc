<?php


namespace MYMVC\CONTROLLERS;


use http\Header;
use MongoDB\Driver\Exception\Exception;
use MYMVC\LIB\filter;
use MYMVC\LIB\Helper;
use MYMVC\LIB\Messenger;
use MYMVC\MODELS\notificationmodel;
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
        'Phone' => 'phone',
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

                $notification = new notificationmodel('notif_user_title' , 'notif_user_content_add' , 'notif_type_0' ,
                    $this->getsession()->getuser()->getUserId() , '/users/edit/'.$user->getUserId() , $user->getUsername());
                $notification->save();

                $this->_msg->addMsg($this->_language->feed_msg('msg_success_add', [$user->getUsername()]), Messenger::Msg_success);
            } catch (PDOException $e) {
                $this->_msg->addMsg($this->getLang()->get('msg_error_edit'), Messenger::Msg_error);
            }
            $this->redirect('/users');
        }

        $this->_data['groups'] = UsersGroupsModel::getAll();
        $this->view();
    }

    public function editAction()
    {
        $id = isset($this->_params[0]) ? $this->filterInt($this->_params[0]) : '';
        $user = UsersModel::getByPK($id , ' join users_group on users_group.group_id = users.group_id ');
        if ($user != false && isset($_SERVER['HTTP_REFERER']) && $user->getUserId() != $this->getsession()->u->getUserId()) {
        $olduser = clone $user;
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
                    if($user_edit != $olduser){
                        $olduser->removePassword();
                        $olduser->statue_name = $this->getLang()->get('user_statue_'.$olduser->getStatus());
                        $olduser->removestatues();
                        $opject_old = serialize($olduser);
                        $notification = new notificationmodel('notif_user_title' , 'notif_user_content_edit' , 'notif_type_1' ,
                            $this->getsession()->getuser()->getUserId() , '/users/edit/'.$olduser->getUserId() , $user_edit->getUsername());
                        $notification->setObject($opject_old);
                        $notification->save();
                    }

                    if ($olduser->getUsername() == $_POST['Username']) {
                        $this->_msg->addMsg($this->_language->feed_msg('msg_success_edit', [$user->getUsername()]), Messenger::Msg_success);
                    } else {
                        $this->_msg->addMsg($this->_language->feed_msg('msg_success_edit_user', [$olduser->getUsername(), $_POST['Username']]), Messenger::Msg_success);
                    }

                } catch (PDOException $e) {
                    $this->_msg->addMsg($this->getLang()->get('msg_error_edit'), Messenger::Msg_error);
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

    public function changepassAction()
    {
        $id = $this->getsession()->getuser()->getUserId();
        $user = UsersModel::getByPK($id);

        $this->rules_to_valid = [
            'Email' => 'req|vemail',
            'CEmail' => 'req|vemail|eqinput(Email)',
            'Phone' => 'phone',
        ];

            $this->_language->load('users', 'edit'); // language edit
            $this->_language->load('users', 'label'); // language label input
            $this->_language->load('users', 'msgs'); // language for msgs success and faild
            $this->_language->load('validation', 'errors'); // langauge for validation error in same page

            $this->rules_to_valid['Password'] = 'sbetween(6,20)'; //change rule for Password make it not required
            $this->rules_to_valid['CPassword'] = 'sbetween(6,20)|eqinput(Password)'; //change rule for Password make it not required


            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']) && $this->is_valid($this->rules_to_valid, $_POST) == true) {

                $password = $_POST['Password'] == '' ? $user->getPassword() : UsersModel::cryptPassword($_POST['Password']);
                $user_edit = $user->edit_action_construct($user->getUsername(), $password, $_POST['Email'], $_POST['Phone'], $user->getGroupId());
                $user_edit->setUserId($user->getUserId());
                try {
                    $user_edit->save();
                    $this->_msg->addMsg($this->_language->feed_msg('msg_success_myuser_edit', [$user->getUsername()]), Messenger::Msg_success);


                } catch (PDOException $e) {
                    $this->_msg->addMsg($this->getLang()->get('msg_error_edit'), Messenger::Msg_error);
                }
                $this->redirect('/users/changepass');
            }


            $this->_data['userActive'] = $user;
            $this->view();

    }

    public function deleteAction()
    {
        if (isset($this->_params[0]) && is_numeric($this->_params[0]) && isset($_SERVER['HTTP_REFERER'])) {
            $user_id = $this->filterInt($this->_params[0]);
            $user = UsersModel::getByPK($user_id , ' join users_group on users_group.group_id = users.group_id ');
            $this->getLang()->load('users', 'msgs');

            if (!empty($user) && $user->getUserId() != $this->getsession()->u->getUserId()) {
                try {
                    $user->delete();

                    $user->removePassword();
                    $user->statue_name = $this->getLang()->get('user_statue_'.$user->getStatus());
                    $user->removestatues();
                    $opject_old = serialize($user);
                    $notification = new notificationmodel('notif_user_title' , 'notif_user_content_delete' , 'notif_type_2' ,
                        $this->getsession()->getuser()->getUserId() , '/users/edit/'.$user->getUserId() , $user->getUsername());
                    $notification->setObject($opject_old);
                    $notification->save();

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

    public function permitAction()
    {
        if (isset($this->_params[0]) && is_numeric($this->_params[0]) && isset($_SERVER['HTTP_REFERER'])) {
            $user_id = $this->filterInt($this->_params[0]);
            $user = UsersModel::getByPK($user_id , ' join users_group on users_group.group_id = users.group_id ' );
            $this->getLang()->load('users', 'msgs');

            if (!empty($user) && $user->getUserId() != $this->getsession()->u->getUserId()) {
                try {
                    $text_msg = '';
                    if ($user->getStatus() == 1 || $user->getStatus() == 3) {
                        $user->setStatus(2);
                        $text_msg = 'msg_success_block';
                    } elseif ($user->getStatus() == 2) {
                        $user->setStatus(3);
                        $text_msg = 'msg_success_unblock';
                    }
                    $user->save();

                        $user->removePassword();
                        $user->statue_name = $this->getLang()->get('user_statue_'.$user->getStatus());
                        $user->removestatues();
                        $opject_old = serialize($user);
                        $notification = new notificationmodel('notif_user_title' , 'notif_user_content_edit' , 'notif_type_1' ,
                            $this->getsession()->getuser()->getUserId() , '/users/edit/'.$user->getUserId() , $user->getUsername());
                        $notification->setObject($opject_old);
                        $notification->save();


                    $msg = $this->getLang()->feed_msg($text_msg, [$user->getUsername()]);
                    $this->getmsg()->addMsg($msg, Messenger::Msg_success);
                } catch (PDOException $e) {
                    $msg = $this->getLang()->get('msg_error_permit');
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


            if (isset($_SERVER['HTTP_REFERER'])) {
                $url = explode('/', trim(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH), '/'), 3);

                if (is_object($user) && !empty($user)) {
                    if (isset($url[2]) && $url[2] == $user->getUserId() ){
                        echo 0;
                    }else{
                        echo 1;
                    }
                } else {
                    echo 0;
                }
            }
        }

    }


}
<?php


namespace MYMVC\CONTROLLERS;


use http\Header;
use MYMVC\LIB\filter;
use MYMVC\LIB\Helper;
use MYMVC\LIB\Messenger;
use MYMVC\MODELS\UsersGroupsModel;
use MYMVC\MODELS\UsersModel;
use MYMVC\MODELS\UsersprofileModel;
use PDOException;

class usersprofileController extends AbstractController
{
    use Helper;
    use filter;

    private $rules_to_valid = [
        'firstname' => 'req|alpha|sbetween(3,10)',
        'lastname' => 'req|alpha|sbetween(3,10)',
        'address' => '',
        'image' => 'req|image_ext|image_size',
        'dob' => 'myvdate',
    ];


    public function addAction()
    {
        if (isset($this->getsession()->profile) && is_numeric($this->getsession()->profile)) {

            $userid = $this->filterInt($this->getsession()->profile);
            $user = UsersModel::getByPK($userid);
            if (!empty($user) && $user->getStatus() == 3) {

                $view = array_intersect([':view' => 'view'], $this->_template->getTemplate());
                $this->_template->changeTemplate($view);

                $this->getLang()->load('usersprofile', 'add');
                $this->getLang()->load('usersprofile', 'label');
                $this->getLang()->load('usersprofile', 'msgs');
                $this->getLang()->load('validation', 'errors');


                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']) && $this->is_valid($this->rules_to_valid, $_POST) == true) {
                        try {
                            $usersprofile = new UsersprofileModel($userid, $_POST['firstname'], $_POST['lastname'], $_POST['address'], $_FILES['image'], $_POST['dob']);
                            $usersprofile->uploadImage($_FILES['image']);
                        $usersprofile->save(false);
                        $user->setStatus(1);
                        $user->setLastLogin(date('Y-m-d h:i:s'));
                        $user->save();
                        $user->user_save_in_session_wzout_pass($user, $this->getsession());
                        $this->_msg->addMsg($this->_language->feed_msg('msg_success_user_profile_add', [$user->getUsername()]), Messenger::Msg_success);
                        $this->redirect('/');

                        } catch (PDOException $e) {
                            $this->_msg->addMsg($this->_language->feed_msg('msg_error', [$e->getMessage()]), Messenger::Msg_error);
                        }

                }
                $this->view();


            } else {
                $this->redirect_back();
            }
        } else {
            $this->redirect('/');
        }
    }


}
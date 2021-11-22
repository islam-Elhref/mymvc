<?php

namespace MYMVC\CONTROLLERS;

use MYMVC\LIB\filter;
use MYMVC\LIB\Helper;
use MYMVC\LIB\Messenger;
use MYMVC\LIB\Validation;
use MYMVC\MODELS\notificationmodel;
use MYMVC\MODELS\privilegesmodel;
use PDOException;

class PrivilegesController extends AbstractController
{

    private $rules_to_valid = [
        'name' => 'req|alpha',
        'url' => 'req|url_privilege'
    ];

    use filter;
    use Helper;
    use Validation;
    private $called_class = 'MYMVC\MODELS\privilegesmodel';


    public function defaultAction()
    {
        $this->_language->load('privileges', 'default');
        $this->_data['privileges'] = privilegesmodel::getAll('', 'DESC');
        $this->view();
    }


    public function editAction()
    {
        $this->getLang()->load('privileges', 'edit'); // language file edit
        $this->getLang()->load('privileges' , 'msgs');
        $this->getLang()->load('validation','errors');

        if (isset($this->_params[0])) {
            $privilege_id = abs($this->filterInt($this->_params[0])); // param id privilege
            $privilege = privilegesmodel::getByPK($privilege_id); // object from privilege model
            if (!empty($privilege) && is_a($privilege, $this->called_class)) {

                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']) && $this->is_valid($this->rules_to_valid , $_POST) ) {
                    $privilege_edit = new privilegesmodel($_POST['name'], $_POST['url']);
                    $privilege_edit->setPrivilegeId($this->_params[0]);

                        try {
                           $privilegeName =  $privilege_edit->getPrivilegeName();
                            $privilege_edit->save();

                            if($privilege_edit != $privilege) {
                                $opject_old = serialize($privilege);
                                $notification = new notificationmodel('notif_privilege_title', 'notif_privilege_content_edit', 'notif_type_1',
                                    $this->getsession()->getuser()->getUserId(), '/privileges/edit/' . $privilege->getPrivilegeId(), $privilege_edit->getPrivilegeName());
                                $notification->setObject($opject_old);
                                $notification->save();
                            }

                            $this->_msg->addMsg($this->getLang()->feed_msg('msg_success_edit',[$privilegeName]) , Messenger::Msg_success);
                        } catch (PDOException $e) {
                            $this->_msg->addMsg( $this->getLang()->get('msg_error_add') , Messenger::Msg_error);
                        }

                    $this->redirect('/privileges');
                }

                $this->_data['privilege'] = $privilege;
                $this->view();

            } else {
                $this->redirect('/privileges');
            }
        } else {
            $this->redirect('/privileges');
        }
    }

    public function addAction()
    {
        $this->_language->load('privileges', 'add');
        $this->_language->load('privileges', 'msgs');
        $this->getLang()->load('validation','errors');

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit']) && $this->is_valid($this->rules_to_valid , $_POST) ) {
            $new_privilege = new privilegesmodel($_POST['name'], $_POST['url']);

                try {
                    $new_privilege->save();

                    $notification = new notificationmodel('notif_privilege_title' , 'notif_privilege_content_add' , 'notif_type_0' ,
                        $this->getsession()->getuser()->getUserId() , '/privileges/edit/'.$new_privilege->getPrivilegeId() , $new_privilege->getPrivilegeName());
                    $notification->save();

                    $privilegeName = $new_privilege->getPrivilegeName();
                    $this->_msg->addMsg($this->getLang()->feed_msg('msg_success_add' , [$privilegeName] ) , Messenger::Msg_success);
                    $this->redirect('/privileges');
                } catch (PDOException $e) {
                    $this->_msg->addMsg($this->getLang()->get('msg_error_add') , Messenger::Msg_error);
                    $this->redirect('/privileges/add');
                }
        }

        $this->view();
    }

    public function deleteAction()
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $path = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
        } else {
            $path = '';
        }

        if (isset($this->_params[0]) && $path == '/privileges') {
            $this->_language->load('privileges', 'msgs');
            $msgs = $this->_language->getDictionary();

            $privilege_id = abs($this->filterInt($this->_params[0]));
            $privilege = privilegesmodel::getByPK($privilege_id);
            if (!empty($privilege) && is_a($privilege, $this->called_class)) {

                try {
                    $opject_old = serialize($privilege);
                    $privilege->delete();


                    $notification = new notificationmodel('notif_privilege_title' , 'notif_privilege_content_delete' , 'notif_type_2' ,
                        $this->getsession()->getuser()->getUserId() , '' , $privilege->getPrivilegeName());
                    $notification->setObject($opject_old);
                    $notification->save();

                    $privilegeName = $privilege->getPrivilegeName();
                    $this->_msg->addMsg($this->getLang()->feed_msg('msg_success_delete',[$privilegeName]) , Messenger::Msg_success);

                } catch (PDOException $e) {
                    $this->_msg->addMsg($msgs['msg_error_add'] , Messenger::Msg_error);
                }
                $this->redirect('/privileges');

            } else {
                $this->redirect('/privileges');
            }
        } else {
            $this->redirect('/privileges');
        }
    }


}
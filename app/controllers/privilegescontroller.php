<?php

namespace MYMVC\CONTROLLERS;

use MYMVC\LIB\filter;
use MYMVC\LIB\Helper;
use MYMVC\LIB\Messenger;
use MYMVC\MODELS\privilegesmodel;
use PDOException;

class PrivilegesController extends AbstractController
{
    use filter;
    use Helper;
    private $called_class = 'MYMVC\MODELS\privilegesmodel';


    public function defaultAction()
    {
        $this->_language->load('privileges', 'default');
        $this->_data['privileges'] = privilegesmodel::getAll('', 'DESC');
        $this->view();
    }


    public function editAction()
    {
        $this->_language->load('privileges' , 'msgs');
        $msgs = $this->_language->getDictionary();

        if (isset($this->_params[0])) {
            $privilege_id = abs($this->filterInt($this->_params[0])); // param id privilege
            $privilege = privilegesmodel::getByPK($privilege_id); // object from privilege model
            if (!empty($privilege) && is_a($privilege, $this->called_class)) {

                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
                    $privilege_edit = new privilegesmodel($_POST['name'], $_POST['url']);
                    $privilege_edit->setPrivilegeId($this->_params[0]);

                    if ($privilege_edit->check_input_empty() === true) {
                        try {
                           $privilegeName =  $privilege_edit->getPrivilegeName();
                            $privilege_edit->save();
                            $msg_success = str_replace('name', $privilegeName, $msgs['msg_success_edit']);
                            $this->_msg->addMsg($msg_success , Messenger::Msg_success);
                        } catch (PDOException $e) {
                            $this->_msg->addMsg($msgs['msg_error_add'] , Messenger::Msg_error);
                        }
                    }
                    $this->redirect('/privileges');
                }
                $this->_language->load('privileges', 'edit'); // language file edit
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
        $msgs = $this->_language->getDictionary();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            $new_privilege = new privilegesmodel($_POST['name'], $_POST['url']);

            if ($new_privilege->check_input_empty() === true) {
                try {
                    $new_privilege->save();
                    $privilegeName = $new_privilege->getPrivilegeName();
                    $msg_success = str_replace('name', $privilegeName, $msgs['msg_success_add']);
                    $this->_msg->addMsg($msg_success , Messenger::Msg_success);
                } catch (PDOException $e) {
                    $this->_msg->addMsg($msgs['msg_error_add'] , Messenger::Msg_error);
                }
            }
            $this->redirect('/privileges');
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
                    $privilege->delete();
                    $privilegeName = $privilege->getPrivilegeName();
                    $msg_success = str_replace('name', $privilegeName, $msgs['msg_success_delete']);
                    $this->_msg->addMsg($msg_success , Messenger::Msg_success);

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
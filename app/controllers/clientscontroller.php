<?php

namespace MYMVC\CONTROLLERS;

use MYMVC\LIB\Messenger;
use MYMVC\MODELS\clientsmodel;
use MYMVC\MODELS\notificationmodel;

class clientscontroller extends AbstractController
{


    private $rule_for_validation = [
        "name" => 'req|alpha|sbetween(4,40)',
        "email" => 'req|vemail|smax(40)',
        "phone" => 'req|phone',
        "address" => 'req|alphanum|sbetween(4,50)',
    ];

    public function defaultAction()
    {
        $this->getLang()->load('clients', 'default');

        $this->_data['clients'] = clientsmodel::getAll();
        $this->view();
    }

    public function addAction()
    {

        $this->getLang()->load('clients', 'add');
        $this->getLang()->load('clients', 'label');
        $this->getLang()->load('clients', 'msgs');
        $this->getLang()->load('clients', 'msgs');
        $this->getLang()->load('validation', 'errors');


        if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['submit']) && $this->is_valid($this->rule_for_validation, $_POST)) {
            $client = new clientsmodel($_POST['name'], $_POST['phone'], $_POST['email'], $_POST['address']);
            try {
                $client->save();

                $notification = new notificationmodel('notif_client_title' , 'notif_client_content_add' , 'notif_type_0' ,
                    $this->getsession()->getuser()->getUserId() , '/clients/edit/'.$client->getclientsId() , $client->getName());
                $notification->save();

                $msg = $this->getLang()->feed_msg('msg_success_add', [$_POST['name']]);
                $this->getmsg()->addMsg($msg, Messenger::Msg_success);
                $this->redirect('/clients');
            } catch (\PDOException $e) {
                if ($client->check_exist() != false && is_array($client->check_exist())) {
                    $arrays = $client->check_exist();
                    foreach ($arrays as $msgerror) {
                        $msg = $this->getLang()->get($msgerror);
                        $this->getmsg()->addMsg($msg, Messenger::Msg_error);
                    }
                } else {
                    $this->getmsg()->addMsg($this->getLang()->get('msg_error_edit'), Messenger::Msg_error);
                }
            }
        }

        $this->view();
    }

    public function editAction()
    {

        if (isset($this->_params[0]) && is_numeric($this->_params[0])) {
            $this->getLang()->load('clients', 'edit');
            $this->getLang()->load('clients', 'label');
            $this->getLang()->load('clients', 'msgs');
            $this->getLang()->load('validation', 'errors');

            $client_id = $this->_params['0'];
            $oldclient = clientsmodel::getByPK($client_id);
            $this->_data['client'] = $oldclient;

            if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) && $this->is_valid($this->rule_for_validation, $_POST)) {
                $client = new clientsmodel($_POST['name'], $_POST['phone'], $_POST['email'], $_POST['address']);
                $client->setclientsId($this->filterInt($client_id));
                try {
                    if ($client->check_exist() != false && is_array($client->check_exist())) {
                        throw new \PDOException('there is dublcate value');
                    }else{
                        $client->save();

                        if($client != $oldclient) {
                            $opject_old = serialize($oldclient);
                            $notification = new notificationmodel('notif_client_title', 'notif_client_content_edit', 'notif_type_1',
                                $this->getsession()->getuser()->getUserId(), '/clients/edit/' . $client->getclientsId(), $client->getName());
                            $notification->setObject($opject_old);
                            $notification->save();
                        }

                        if ($oldclient->getName() != $client->getName()) {
                            $msg = $this->getLang()->feed_msg('msg_success_edit_name', [$oldclient->getName(), $client->getName()]);
                        } else {
                            $msg = $this->getLang()->feed_msg('msg_success_edit', [$client->getName()]);
                        }
                        $this->getmsg()->addMsg($msg, Messenger::Msg_success);
                        $this->redirect('/clients');
                    }
                } catch (\PDOException $e) {

                    if ($client->check_exist() != false && is_array($client->check_exist())) {
                        $arrays = $client->check_exist();
                        foreach ($arrays as $msgerror) {
                            $msg = $this->getLang()->get($msgerror);
                            $this->getmsg()->addMsg($msg, Messenger::Msg_error);
                        }
                    } else {
                        $this->getmsg()->addMsg($this->getLang()->get('msg_error_edit'), Messenger::Msg_error);
                    }
                }
            }

            $this->view();
        } else {
            $this->redirect_back();
        }
    }

    public function deleteAction()
    {

        if (isset($this->_params[0]) && is_numeric($this->_params[0]) && isset($_SERVER['HTTP_REFERER']) && parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) == '/clients') {
            $this->getLang()->load('clients', 'msgs');
            $client_id = $this->_params['0'];
            $client = clientsmodel::getByPK($client_id);
            if (!empty($client)) {
                try {
                    $opject_old = serialize($client);

                    $client->delete();

                    $notification = new notificationmodel('notif_client_title' , 'notif_client_content_delete' , 'notif_type_2' ,
                        $this->getsession()->getuser()->getUserId() , '' , $client->getName());
                    $notification->setObject($opject_old);
                    $notification->save();

                    $msg = $this->getLang()->feed_msg('msg_success_delete', [$client->getName()]);
                    $this->getmsg()->addMsg($msg, Messenger::Msg_success);

                } catch (\PDOException $e) {
                    $msg = $this->getLang()->get('msg_error_delete');
                    $this->getmsg()->addMsg($msg, Messenger::Msg_error);
                }
            }
        }
        $this->redirect('/clients');
    }

}

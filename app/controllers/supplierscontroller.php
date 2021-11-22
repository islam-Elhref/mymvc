<?php

namespace MYMVC\CONTROLLERS;

use MYMVC\LIB\Messenger;
use MYMVC\MODELS\notificationmodel;
use MYMVC\MODELS\suppliersmodel;

class supplierscontroller extends AbstractController
{


    private $rule_for_validation = [
        "name" => 'req|alpha|sbetween(4,40)',
        "email" => 'req|vemail|smax(40)',
        "phone" => 'req|phone',
        "address" => 'req|alphanum|sbetween(4,50)',
    ];

    public function defaultAction()
    {
        $this->getLang()->load('suppliers', 'default');

        $this->_data['suppliers'] = suppliersmodel::getAll();
        $this->view();
    }

    public function addAction()
    {

        $this->getLang()->load('suppliers', 'add');
        $this->getLang()->load('suppliers', 'label');
        $this->getLang()->load('suppliers', 'msgs');
        $this->getLang()->load('suppliers', 'msgs');
        $this->getLang()->load('validation', 'errors');


        if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['submit']) && $this->is_valid($this->rule_for_validation, $_POST)) {
            $supplier = new suppliersmodel($_POST['name'], $_POST['phone'], $_POST['email'], $_POST['address']);
            try {
                $supplier->save();

                $notification = new notificationmodel('notif_supplier_title' , 'notif_supplier_content_add' , 'notif_type_0' ,
                    $this->getsession()->getuser()->getUserId() , '/suppliers/edit/'.$supplier->getSuppliersId() , $supplier->getName());
                $notification->save();

                $msg = $this->getLang()->feed_msg('msg_success_add', [$_POST['name']]);
                $this->getmsg()->addMsg($msg, Messenger::Msg_success);
                $this->redirect('/suppliers');
            } catch (\PDOException $e) {
                if ($supplier->check_exist() != false && is_array($supplier->check_exist())) {
                    $arrays = $supplier->check_exist();
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
            $this->getLang()->load('suppliers', 'edit');
            $this->getLang()->load('suppliers', 'label');
            $this->getLang()->load('suppliers', 'msgs');
            $this->getLang()->load('validation', 'errors');

            $supplier_id = $this->_params['0'];
            $oldsupplier = suppliersmodel::getByPK($supplier_id);
            $this->_data['supplier'] = $oldsupplier;

            if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) && $this->is_valid($this->rule_for_validation, $_POST)) {
                $supplier = new suppliersmodel($_POST['name'], $_POST['phone'], $_POST['email'], $_POST['address']);
                $supplier->setSuppliersId($this->filterInt($supplier_id));
                try {
                    $supplier->save();

                    if($supplier != $oldsupplier) {
                        $opject_old = serialize($oldsupplier);
                        $notification = new notificationmodel('notif_supplier_title', 'notif_supplier_content_edit', 'notif_type_1',
                            $this->getsession()->getuser()->getUserId(), '/suppliers/edit/' . $supplier->getSuppliersId(), $supplier->getName());
                        $notification->setObject($opject_old);
                        $notification->save();
                    }
                    if ($oldsupplier->getName() != $supplier->getName()) {
                        $msg = $this->getLang()->feed_msg('msg_success_edit_name', [$oldsupplier->getName(), $supplier->getName()]);
                    } else {
                        $msg = $this->getLang()->feed_msg('msg_success_edit', [$supplier->getName()]);
                    }
                    $this->getmsg()->addMsg($msg, Messenger::Msg_success);
                    $this->redirect('/suppliers');
                } catch (\PDOException $e) {

                    if ($supplier->check_exist() != false && is_array($supplier->check_exist())) {
                        $arrays = $supplier->check_exist();
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

        if (isset($this->_params[0]) && is_numeric($this->_params[0]) && isset($_SERVER['HTTP_REFERER']) && parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) == '/suppliers') {
            $this->getLang()->load('suppliers', 'msgs');
            $supplier_id = $this->_params['0'];
            $supplier = suppliersmodel::getByPK($supplier_id);
            if (!empty($supplier)) {
                try {
                    $opject_old = serialize($supplier);
                    $supplier->delete();

                    $notification = new notificationmodel('notif_supplier_title' , 'notif_supplier_content_delete' , 'notif_type_2' ,
                        $this->getsession()->getuser()->getUserId() , '' , $supplier->getName());
                    $notification->setObject($opject_old);
                    $notification->save();

                    $msg = $this->getLang()->feed_msg('msg_success_delete', [$supplier->getName()]);
                    $this->getmsg()->addMsg($msg, Messenger::Msg_success);

                } catch (\PDOException $e) {
                    $msg = $this->getLang()->get('msg_error_delete');
                    $this->getmsg()->addMsg($msg, Messenger::Msg_error);
                }
            }
        }
        $this->redirect('/suppliers');
    }

}

<?php

namespace MYMVC\CONTROLLERS;

use MYMVC\LIB\Messenger;
use MYMVC\MODELS\suppliersmodel;

class supplierscontroller extends AbstractController
{


    private $rule_for_validation = [
        "name"      => 'req|alpha|sbetween(4,40)',
        "email"     => 'req|vemail|sbetween(4,40)',
        "phone"     => 'req|int|sbetween(4,40)',
        "address"   => 'req|alphanum|sbetween(4,50)',
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


        if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['submit']) && $this->is_valid($this->rule_for_validation , $_POST) ) {
            $supplier = new suppliersmodel($_POST['name'] , $_POST['phone'] , $_POST['email'] , $_POST['address']  );
            try {
                $supplier->save();
                $msg =  $this->getLang()->feed_msg('msg_success_add' , [$_POST['name']]);
                $this->getmsg()->addMsg($msg , Messenger::Msg_success);
                $this->redirect('/suppliers');
            }catch (\PDOException $e){
                $email = 'email';
                $supplier = suppliersmodel::getone(["$email" => $this->filterString($_POST[$email])]);
                if (!empty($supplier) && is_object($supplier)){
                    $msg =  $this->getLang()->feed_msg('msg_error_exist' , [$_POST['email']]);
                    $this->getmsg()->addMsg($msg , Messenger::Msg_error);
                }else{
                    $this->getmsg()->addMsg($this->getLang()->get('msg_error_edit') , Messenger::Msg_error);
                }
            }
        }

        $this->view();
    }

    public function supplierexistAction(){
        // $_post['input'] دي بس بتديني اسم الانبوت
        // $_post[$_post[input]]   ادي بتديني القيمه بتاعة الانبوت اللي جبته من الكود السابق

        if (isset($_POST[$_POST['input']])) {
            header('content-type: text/plain');
            $user = suppliersmodel::getone(["$_POST[input]" => $this->filterString($_POST[$_POST['input']])]);
            if (is_object($user) && !empty($user)) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }
}

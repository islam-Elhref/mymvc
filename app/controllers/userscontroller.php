<?php


namespace MYMVC\CONTROLLERS;


use MYMVC\MODELS\UsersModel;

class usersController extends AbstractController
{

    public function defaultAction(){
        $this->_language->load('users','default');
        $this->_data['users'] = UsersModel::getAll();
        $this->view();
    }

    public function addAction(){
        $this->_language->load('users' , 'add');

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
//            $new_user = new UsersModel($username, $password, $email, $phone, $group_id, $subscription_date, $last_login)
        }

        $this->view();
    }

}
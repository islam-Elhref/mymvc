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

}
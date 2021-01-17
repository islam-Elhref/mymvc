<?php


namespace MYMVC\CONTROLLERS;


use MYMVC\MODELS\UsersGroupsModel;

class UsersGroupsController extends AbstractController
{

    public function defaultAction(){
        $this->_language->load('usersgroups','default');
        $this->_data['usersgroups'] = UsersGroupsModel::getAll();
        $this->view();
    }


    public function addAction(){
        $this->_language->load('usersgroups','add');
        $this->view();
    }
}
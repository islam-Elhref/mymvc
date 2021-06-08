<?php


namespace MYMVC\CONTROLLERS;


use MYMVC\LIB\Helper;
use MYMVC\MODELS\UsersGroupsModel;
use MYMVC\MODELS\UsersModel;

class usersController extends AbstractController
{
    use Helper;

    private $rules_to_valid = [
            'Username'      => 'req|alphanumEn|smin(6)|smax(20)',
            'Password'      => 'req|smin(6)|smax(20)',
            'CPassword'     => 'req|smin(6)|smax(20)',
            'Email'         =>  'req|vemail',
            'CEmail'        =>  'req|vemail',
            'Phone'         =>  'int' ,
            'group_id'      => 'req|int'
        ];
    private $lang ;

    public function defaultAction(){
        $this->_language->load('users','default');
        $this->_data['users'] = UsersModel::getAll();
        $this->view();
    }

    public function addAction(){
        $this->_language->load('users' , 'add');
        $this->_language->load('users' , 'msgs');

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
           $this->is_valid($this->rules_to_valid, $_POST);
        }

        $this->_data['groups'] = UsersGroupsModel::getAll();
        $this->view();
    }

}
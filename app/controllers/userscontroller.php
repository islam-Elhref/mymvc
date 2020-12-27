<?php


namespace MYMVC\CONTROLLERS;


class usersController extends AbstractController
{

    public function defaultAction(){
        $this->_language->load('users','default');
        $this->view();
    }

}
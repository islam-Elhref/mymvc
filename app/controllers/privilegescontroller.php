<?php


namespace MYMVC\CONTROLLERS;


use MYMVC\MODELS\privilegesmodel;

class PrivilegesController extends AbstractController
{

    public function defaultAction(){
        $this->_language->load('privileges' , 'default' );
        $this->_data['privileges'] = privilegesmodel::getAll() ;
        $this->view();
    }

    public function addAction(){
        $this->_language->load('privileges' , 'add' );
        $this->view();
    }

}
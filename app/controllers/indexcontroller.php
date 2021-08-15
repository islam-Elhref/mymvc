<?php


namespace MYMVC\CONTROLLERS;


use MYMVC\LIB\Validation;
use MYMVC\MODELS\privilegecontrolmodel;

class IndexController extends AbstractController
{
use Validation ;

    public function defaultAction(){

        $this->_language->load('Index','default');
        $this->view();
    }

}
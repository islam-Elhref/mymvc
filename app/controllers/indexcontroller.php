<?php


namespace MYMVC\CONTROLLERS;


use MYMVC\LIB\Validation;

class IndexController extends AbstractController
{
use Validation ;

    public function defaultAction(){
        var_dump($this->between('محمد',6 , 1));
        $this->_language->load('Index','default');
        $this->view();
    }

}
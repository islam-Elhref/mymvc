<?php


namespace MYMVC\CONTROLLERS;


class AccessDeniedController extends AbstractController
{
    public function defaultAction(){
        $this->view();
    }
}
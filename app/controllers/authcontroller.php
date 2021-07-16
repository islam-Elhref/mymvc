<?php


namespace MYMVC\CONTROLLERS;


use MYMVC\LIB\Language;

class AuthController extends AbstractController
{

    public function loginAction()
    {
        $view = array_intersect([':view' => 'view'], $this->_template->getTemplate());
        $this->_template->changeTemplate($view);
        $this->_language->load('auth' , 'login');

        $this->view();
    }

}
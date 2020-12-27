<?php

namespace MYMVC\LIB;


class FrontController
{
    const NOT_FOUND_CONTROLLER = 'MYMVC\CONTROLLERS\\' . 'NotFoundController';
    const NOT_FOUND_ACTION = 'notfoundAction';
    private $_controller;
    private $_action;
    private $template;
    private $language;
    private $session;
    private $_params = [];

    public function __construct(Template $template , Language $language , MySession $session)
    {
        $this->language = $language;
        $this->template = $template;
        $this->session = $session;
        $this->parse_url();
    }

    private function parse_url()
    {
        $url = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $url = explode('/', $url, 3);

        $this->_controller = isset($url[0]) && $url[0] !== '' ? $url[0] : 'index';
        $this->_action = isset($url[1]) && $url[1] !== '' ? $url[1] : 'default';
        $this->_params = isset($url[2]) && $url[2] !== '' ? explode('/', $url[2]) : [];

    }

    public function dispatch()
    {

        $Class_controller = 'MYMVC\CONTROLLERS\\' . ucfirst($this->_controller) . 'Controller';
        $actionName = lcfirst($this->_action) . 'Action';

        if (!class_exists($Class_controller)) {
            $Class_controller = self::NOT_FOUND_CONTROLLER;
        }
        $controller = new $Class_controller();

        if (!method_exists($controller, $actionName)) {
            $this->_action = $actionName = $this::NOT_FOUND_ACTION;
        }


        $controller->setController($this->_controller);
        $controller->setAction($this->_action);
        $controller->setparams($this->_params);
        $controller->setTemplate($this->template);
        $controller->setlanguage($this->language);
        $controller->setSession($this->session);

        $controller->$actionName();
    }

}


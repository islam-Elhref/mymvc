<?php

namespace MYMVC\LIB;


class FrontController
{
    use Helper;

    const NOT_FOUND_CONTROLLER = 'MYMVC\CONTROLLERS\\' . 'NotFoundController';
    const NOT_FOUND_ACTION = 'notfoundAction';
    private $_controller;
    private $_action;
    private $template;
    private $registry;
    /**
     * @var Authantcation
     */
    private $auth;
    private $_params = [];

    public function __construct(Template $template, Registry $registry, Authantcation $auth)
    {
        $this->registry = $registry;
        $this->template = $template;
        $this->auth = $auth;
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

        if (!$this->auth->is_authantcate() && $this->_controller != 'language') {
            $Class_controller = 'MYMVC\CONTROLLERS\\' . 'AuthController';
            $this->_controller = 'auth';
            $this->_action = 'login';
            $actionName = lcfirst($this->_action) . 'Action';
        } else {

            if ($this->auth->is_authantcate() == 3) {

                if (($this->_controller != 'usersprofile' && $this->_action != 'add') && ($this->_controller != 'auth' && $this->_action != 'logout')) {
                    $this->redirect('/usersprofile/add');
                }
            }

        }

        if (!class_exists($Class_controller)) {
            $this->_controller = 'notfound';
            $Class_controller = self::NOT_FOUND_CONTROLLER;
        }
        $controller = new $Class_controller();

        if (!method_exists($controller, $actionName)) {
            $this->_action = 'notfound';
            $actionName = $this::NOT_FOUND_ACTION;
        }
// لو الصفحه المراده غير موجوده في الاراي الخاصه بالاكونت ولو انا مفعل هذه الخاصيه من الكونفيج
        if ((!$this->auth->hasAccess($this->_controller, $this->_action)) && Access_Privileges === true ) {
            $this->redirect('/accessdenied/default');
        }
// for if some one open link direct
        if (($this->_controller == 'accessdenied' && $this->_action == 'default' && !isset($_SERVER['HTTP_REFERER']))) {
            $this->redirect('/');
        }

        $controller->setController($this->_controller);
        $controller->setAction($this->_action);
        $controller->setparams($this->_params);
        $controller->setTemplate($this->template);
        $controller->setRegistry($this->registry);

        $controller->$actionName();
    }

}


<?php

namespace MYMVC\CONTROLLERS;

use MYMVC\LIB\filter;
use MYMVC\LIB\FrontController;
use MYMVC\LIB\Helper;
use MYMVC\LIB\Language;
use MYMVC\LIB\Messenger;
use MYMVC\LIB\MySession;
use MYMVC\LIB\Registry;
use MYMVC\LIB\Template;
use MYMVC\LIB\Validation;

class AbstractController
{
    use Validation;
    use filter;
    use Helper;

    private $_controller;
    private $_action;
    protected $_params;
    /**
     * @var Template
     */
    protected $_template;
    /**
     * @var Registry
     */
    protected $registry;
    protected $_data = [];


    protected function getLang(): Language
    {
        return $this->_language;
    }
    protected function getmsg(): Messenger{
        return $this->_msg;
    }

    protected function getsession(): MySession{
        return $this->_sessions;
    }

    public function notfoundAction()
    {
        $this->_language->load('notfound','default');
        $this->view();
    }

    public function setController($controller)
    {
        $this->_controller = $controller;
    }

    public function setAction($action)
    {
        $this->_action = $action;
    }

    public function setParams($params)
    {
        $this->_params = $params;
    }

    public function setTemplate($template)
    {
        $this->_template = $template;
    }

    public function setRegistry($registry)
    {
        $this->registry = $registry;
    }

    public function __get($opject)
    {
           return $this->registry->$opject;
    }



    public function view()
    {
        $file_view = VIEWS_PATH . $this->_controller . DS . $this->_action . '.view.php';

        if ($this->_action == FrontController::NOT_FOUND_ACTION || !file_exists($file_view) ) {
            $this->redirect('/notfound');
        }

        $this->_language->load('template','default');

        $this->_data = array_merge($this->_data, $this->_language->getDictionary());

        $this->_template->setData($this->_data);
        $this->_template->setRegistry($this->registry);

        $this->_template->render($file_view);

    }


}
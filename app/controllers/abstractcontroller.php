<?php


namespace MYMVC\CONTROLLERS;


use MYMVC\LIB\FrontController;

class AbstractController
{
    private $_controller;
    private $_action;
    protected $_params;
    protected $_template;
    protected $_language;
    protected $_session;
    protected $_data = [];

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

    public function setLanguage($language)
    {
        $this->_language = $language;
    }


    public function setSession($session)
    {
        $this->_session = $session;
    }



    public function view()
    {
        $file_view = VIEWS_PATH . $this->_controller . DS . $this->_action . '.view.php';

        if ($this->_action == FrontController::NOT_FOUND_ACTION || !file_exists($file_view) ) {
            $file_view = VIEWS_PATH . 'notfound' . DS . 'notfound.view.php';
        }

        $this->_language->load('template','default');

        $this->_data = array_merge($this->_data, $this->_language->getDictionary());

        $this->_data['session'] = $_SESSION;

        $this->_template->setData($this->_data);
        $this->_template->render($file_view);

    }


}
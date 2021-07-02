<?php

namespace MYMVC\LIB;


class Template
{
    private $template;
    private $data;
    private $registry;

    public function __construct($template)
    {
        $this->template = $template;
    }

    public function showvalue($fieldname , $object = null){
        if (isset($_POST[$fieldname])){
            return $_POST[$fieldname];
        }else{
            if ($object != null) {
                $input = "get$fieldname";
                return  $object->$input();
            }else{
                return '' ;
            }
        }
    }

    public function in_old($array, $value)
    {
        if (in_array($value, $array)) {
            echo 'checked';
        } else {
            echo '';
        }
    }

    public function GetMessage($want = 'all')
    {
        $messages = $this->_msg->getMsg();
        if ($messages !== null) {

            foreach ($messages as $message) {
                ?>
                <div class="alert p-2 m-1 <?= $message[1] ?> message" id="message"><?= $message[0] ?></div>
                <?php
            }

        }
    }

    public function checkurl($url)
    {
        $parce_url = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $parce_url = explode('/', $parce_url);
        $controller = '/' . $parce_url[0];
        if ($controller === $url) {
            return true;
        } else {
            return false;
        }

    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function setRegistry($registry)
    {
        $this->registry = $registry;
    }

    public function __get($object)
    {
        return $this->registry->$object;
    }


    private function template_header_start()
    {
        extract($this->data);
        require_once temp_PATH . 'template_header_start.php';
    }

    private function header_resources()
    {
        $paths = '';
        $mainLang = 'main_' . $_SESSION['lang'];
        foreach ($this->template['header_resources'] as $key => $path) {
            if ($key == "main_ar" || $key == 'main_en') {
                if ($mainLang == $key) {
                    $paths .= '<link rel="stylesheet" href="' . $path . '">';
                }
            } else {
                $paths .= '<link rel="stylesheet" href="' . $path . '">';
            }
        }
        echo $paths;
    }

    private function template_header_end()
    {
        extract($this->data);
        require_once temp_PATH . 'template_header_end.php';
    }

    private function template_block($view)
    {
        extract($this->data);
        foreach ($this->template['template'] as $key => $path) {
            if ($key == ':view') {
                require_once $view;
            } else {
                require_once $path;
            }
        }
    }

    private function footer_resources()
    {
        $script = '';
        $mainLang = 'js_' . $_SESSION['lang'];
        foreach ($this->template['footer_resources'] as $key => $path) {

            if ($key == "js_ar" || $key == 'js_en') {
                if ($mainLang == $key) {
                    $script .= "<script src='$path'></script>";
                }
            } else {
                $script .= "<script src='$path'></script>";
            }

        }
        echo $script;
    }

    private function template_footer()
    {
        extract($this->data);
        require_once temp_PATH . 'template_footer.php';
    }


    public function render($file_view)
    {
        $this->template_header_start();
        $this->header_resources();
        $this->template_header_end();
        $this->template_block($file_view);
        $this->footer_resources();
        $this->template_footer();
    }
}
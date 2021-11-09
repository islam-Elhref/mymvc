<?php

namespace MYMVC\LIB;


use MYMVC\MODELS\UsersModel;

class Template
{
    private $template;
    private $data;
    private $registry;


    public function __construct($template)
    {
        $this->template = $template;
    }

    /**
     * @return UsersModel
     */
    public function getuser()
    {
        return $this->_sessions->u;
    }

    public function showvalue($fieldname, $object = null)
    {
        if (isset($_POST[$fieldname])) {
            return $_POST[$fieldname];
        } else {
            if ($object != null) {
                $input = "get$fieldname";
                return $object->$input();
            } else {
                return '';
            }
        }
    }

    public function floatlabel($fieldname, $object = null)
    {
        $input = "get$fieldname";
        if ((isset($_POST[$fieldname]) && !empty($_POST[$fieldname])) || ($object != null && $object->$input() != '')) {
            return 'class="active"';
        } else {
            return '';
        }
    }

    public function checkedbtn($fieldname, $object = null)
    {
        $input = "$fieldname";
        if ((isset($_POST[$fieldname]) && !empty($_POST[$fieldname])) || ($object != null && $object->$input() != '')) {
            return 'checked';
        } else {
            return '';
        }
    }

    public function selectedoptions($fieldname, $value, $object = null)
    {
        if (is_array($object)) {
            $input = "get$fieldname";

            foreach ($object as $obj) {
                if (($obj != null && $obj->$input() != '' && $obj->$input() == $value)) {
                    return false;
                }
            }
            return true;
        } else {
            $input = "get$fieldname";
            if ((isset($_POST[$fieldname]) && !empty($_POST[$fieldname]) && $_POST[$fieldname] == $value) || ($object != null && $object->$input() != '' && $object->$input() == $value)) {
                return 'selected';
            } else {
                return '';
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

    /**
     * @return mixed
     */
    public function getTemplate()
    {
        return $this->template['template'];
    }

    public function changeTemplate($newTemplate)
    {
        $this->template['template'] = $newTemplate;
    }

    /**
     * @return mixed
     */
    public function getHeader_resources()
    {
        return $this->template['header_resources'];
    }

    public function changeHeaderResources($newHeader)
    {
        $this->template['header_resources'] = $newHeader;
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
        $loginLang = 'login_' . $_SESSION['lang'];
        foreach ($this->template['header_resources'] as $key => $path) {
            if ($key == "main_ar" || $key == 'main_en' || $key == "login_ar" || $key == 'login_en') {
                if ($mainLang == $key || $loginLang == $key) {
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
        extract($this->data, EXTR_REFS);
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

    /**
     * @param $file_view
     * @var Template
     */
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
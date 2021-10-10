<?php
namespace MYMVC;

use MYMVC\LIB\Authantcation;
use MYMVC\LIB\FrontController;
use MYMVC\LIB\Language;
use MYMVC\LIB\Messenger;
use MYMVC\LIB\MySession;
use MYMVC\LIB\Registry;
use MYMVC\LIB\Template;

require_once '..'.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';
require_once LIB_PATH . 'autoload.php';
$temp_paths = require_once APP_PATH . 'config'.DS.'temp_config.php';


// session;
$mysession = new MySession();
$mysession->start();

if (!isset($mysession->lang)){
    $mysession->lang = defaultLanguage;
}

$language = new Language();
$template = new Template($temp_paths);
$messenger = Messenger::getInstance($mysession);

$authantcation = Authantcation::getInstance($mysession);

$registry = Registry::getInstance();
$registry->_language = $language ;
$registry->_sessions  = $mysession;
$registry->_msg = $messenger;


$controller = new FrontController($template , $registry , $authantcation );
$controller->dispatch();

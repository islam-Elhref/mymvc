<?php
namespace MYMVC;


use MYMVC\LIB\FrontController;
use MYMVC\LIB\Language;
use MYMVC\LIB\MySession;
use MYMVC\LIB\Template;

require_once '..'.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';
require_once LIB_PATH . 'autoload.php';
$temp_paths = require_once APP_PATH . 'config'.DS.'temp_config.php';


// session;
$mysession = new MySession();
$mysession->start();

// session

if (!isset($_SESSION['lang'])){
    $_SESSION['lang'] = defaultLanguage;
}

$language = new Language();
$template = new Template($temp_paths);


$controller = new FrontController($template , $language , $mysession);
$controller->dispatch();






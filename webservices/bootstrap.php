<?php
error_reporting(E_ALL ^ E_NOTICE);
define('ROOT', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
define('BASE_URL', "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER["SCRIPT_NAME"]));
define('LIB_DIR', ROOT . 'lib' . DIRECTORY_SEPARATOR);
?>
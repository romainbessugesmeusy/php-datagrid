<?php

define('LIBRARY_PATH', dirname(__FILE__) . '/../');

set_include_path(LIBRARY_PATH . PATH_SEPARATOR . get_include_path());

function customAutoLoader($class)
{
    $file = LIBRARY_PATH . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    } else {
        $file = LIBRARY_PATH . '/Modules/' . str_replace('\\', '/', $class) . '.php';
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
}

spl_autoload_register('customAutoLoader');
ini_set('xdebug.default_enable', false);
ini_set('xdebug.show_exception_trace', false);
ini_set('display_errors', false);

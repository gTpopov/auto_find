<?php

    define('ROOT_PATH',dirname(__FILE__) . '/');
    define('PROTECTED_PATH', ROOT_PATH . 'protected/');
    define('MODULES_PATH', PROTECTED_PATH . 'modules/');
    define('LIBRARY_PATH', dirname(__FILE__) . '/../framework/');
    //define('LIBRARY_PATH', dirname(__FILE__) . '/framework/');

    $yii     =  LIBRARY_PATH . "yiilite.php";
    $config  =  PROTECTED_PATH . 'config/main.php';

    defined('YII_DEBUG') or define('YII_DEBUG',true);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

    require_once($yii);
    Yii::createWebApplication($config)->run();

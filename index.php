<?php

session_start();

error_reporting(0);

date_default_timezone_set('PRC');

define('TPL','themes/');

define('MODULE','/module/');

define('MYSQL_DEBUG', true);

define('PLUGIN', dirname(__FILE__) . '/plugins/');

define('CONTROL', dirname(__FILE__) . '/control/');

define('ROOT', str_replace('\\', '/', dirname(__FILE__)) . '/');

$mtime = explode(' ', microtime());

$sys_starttime = $mtime[1] + $mtime[0];

require('config.php');

require (CONTROL . 'ROC.class.php');

define('PRE',$GLOBALS['db_config']['db_pre']);

define('SITENAME',$GLOBALS['roc_config']['sitename']);

LoadingClass::LoadingSystem('', array('Error','Secret','Common','DB','Template','Image','Upload','Page'));

ROC::ROC_START();  

?>
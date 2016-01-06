<?php
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
header('content-type:text/html;charset=utf-8');
define('APP_DEBUG',true);
define('APP_PATH','./Application/');
define('WETPL_PATH','./MediaTpl/');
define('WEB_ROOT',str_replace('\\','/',dirname(__FILE__)));
require './Core/ThinkPHP.php';

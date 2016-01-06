<?php
return array(
	//数据库配置d
	'DB_TYPE' => 'mysql',
    'DB_HOST' => 'localhost',
    'DB_USER' => 'root',
    'DB_NAME' => 'route',
    'DB_PWD' => '',
    'DB_PREFIX' => 'rou_',
    'DB_FIELDS_CACHE' => true,

    'DEFAULT_MODULE' => 'Home',
    'DEFAULT_CONTROLLER' => 'ApMain',
    'DEFAULT_ACTION' => 'index',
    //重写模式
    'URL_MODEL' => 2,
    //时区
    'DEFAULT_TIMEZONE'=>'Asia/Singapore',

    'SHOW_PAGE_TRACE' =>false,

    'SUPER_ADMIN_ID' => 1,
    'TMPL_PARSE_STRING' => array (

    ),
    'LAYOUT_ON'=>true,
    'LAYOUT_NAME'=>'Layout/layout',

    //短信接口接口
    'SHORT_MSG' => array(
        'USER' => 'cf_puyunjishu',
        'PASS' => 'a123456',
        'URL' => 'http://121.199.16.178/webservice/sms.php',
        'REMAIN' => 'GetNum', //余额查询
        'SEND' => 'Submit' //短信发送
    ),
);
?>

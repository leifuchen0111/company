<?php
return array(
    'DB_CONFIG1' => array(
        'db_type' => 'mysql',
        'db_host' => 'rdss4ylabmlvdprb8klzmpublic.mysql.rds.aliyuncs.com',
        'db_name' => 'train_admin',
        'db_user' => 'puyun',
        'db_pwd'  => 'puyun2015',
    ),

    'TYPE' => array(
        '电子杂志' => 'article',
        '列车时刻' => 'article',
        '列车影院' => 'video-movie',
        '社会热点' => 'video-news',
        '游戏下载' => 'app',
        '铁路信息' => 'article',
        '联系我们' => 'article',
        '娱乐社区' => 'video-gaoxiao',
        '旅游资讯' => 'video-trival',
        '热门应用' => 'app'


    ),
    'SOURCE_PATH' => array(
        'attatchment' => 'http://www.train-wifi.com/mv/attachment/image/',
        'media'       => 'http://www.train-wifi.com/mv/attachment/media/',
        'image'       => 'http://www.train-wifi.com/mv/attachment/image/',
    ),
    'NAV'=> array(
        '广告管理' => array(
            array('广告管理','Ads/ads'),
        ),
    ),

);


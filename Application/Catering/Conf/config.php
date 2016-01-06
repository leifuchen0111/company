<?php
return array(
    'NAV'=> array(
        '基本信息' => array(
            array('网站信息','Index/index'),
            array('在线预览','Index/preview'),
        ),
        '分类管理' => array(
            array('菜品','CatePro/cate?type=menu'),
            array('游戏','CatePro/cate?type=game'),
            array('应用','CatePro/cate?type=app'),
            array('新闻','CatePro/cate?type=news'),
        ),
        '内容管理' => array(
            array('菜品','Pro/pro?type=menu'),
            array('广告','Ads/ads'),
            array('新闻','News/news?type=news'),
            array('游戏','App/app?type=game'),
            array('应用','App/app?type=app')

        ),

    ),
    'TYPE' => array(
        'menu' => '菜品',
        'app' => '应用',
        'game'=> '游戏',
        'news'=> '新闻',
    ),
    'DB_PREFIX' => 'rou_catering_'

);
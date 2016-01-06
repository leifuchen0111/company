<?php 
namespace Home\Model;
use Think\Model\RelationModel;
class ApMainModel extends RelationModel{
    protected $_link = array(
        //ap配置
        'apconf' => array(
            'mapping_type' => HAS_ONE,
            'mapping_name' => 'apconf',
            'class_name' => 'Apconf',
            'foreign_key' => 'rid'
        ),
        //AP实时状态
        'apnow' => array(
            'mapping_type' => HAS_ONE,
            'mapping_name' => 'apnow',
            'class_name' => 'Apnow',
            'foreign_key' => 'gw_id'
        ),
        //mac白名单
        'whiteMac' => array(
            'mapping_type' => HAS_MANY,
            'mapping_name' => 'whiteMacList',
            'class_name' => 'Macwblist',
            'foreign_key' => 'rid',
            'condition' => 'mtype=\'1\'',
        ),
        //mac 黑名单
        'blackMac' => array(
            'mapping_type' => HAS_MANY,
            'mapping_name' => 'blackMacList',
            'class_name' => 'Macwblist',
            'foreign_key' => 'rid',
            'condition' => 'mtype=\'0\'',
        ),
        //在线mac
        'maclist' => array(
            'mapping_type' => HAS_MANY,
            'mapping_name' => 'macList',
            'class_name'=> 'Mac',
            'foreign_key' => 'rid',
            'condition' => 'status=\'1\''
        ),
        //历史mac
        'macHistory' => array(
            'mapping_type' => HAS_MANY,
            'mapping_name' => 'macHistory',
            'class_name' => 'Mac',
            'foreign_key' => 'rid',
            'condition' => 'status=\'0\''
        ),
        //mac扫描
        'scanMac' => array(
            'mapping_type' => HAS_MANY,
            'mapping_name' => 'macScan',
            'class_name' => 'Macscan',
            'foreign_key' => 'rid'
        ),
        //url黑/白名单
        'whiteUrl' => array(
            'mapping_type' => MANY_TO_MANY,
            'mapping_name' => 'wbUrlList',
            'class_name' => 'Urlwb',
            'foreign_key' => 'rid',
            'relation_foreign_key' => 'uid',
            'relation_table' => 'rou_urlwb_ap',
           
        ),
        'urlHistory' => array(
            'mapping_type' => MANY_TO_MANY,
            'mapping_name' => 'urlHistory',
            'class_name' => 'Url',
            'foreign_key' => 'rid',
            'relation_foreign_key' => 'uid',
            'relation_table' => 'rou_url_ap'
        ),
        'bw' => array(
            'mapping_type' => HAS_ONE,
            'mapping_name' => 'bw',
            'class_name' => 'Bw',
            'foreign_key' => 'rid'
        )
    );
    protected $_scope = array(
        
    );
    
}
?>
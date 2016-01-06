<?php 
namespace Home\Model;
use Think\Model\RelationModel;
use Think\Model;
class MacModel extends RelationModel{
    protected $_link = array(
        //访问历史
        'urlHistory' => array(
          'mapping_type' => HAS_MANY,
          'mapping_name' => 'urlHistory',
          'class_name' => 'Url',
          'foreign_key' => 'mid'
        ),
        //路由历史
        'ap' => array(
            'mapping_type' => BELONGS_TO,
            'mapping_name' => 'apHistory',
            'class_name' => 'ApMain',
            'foreign_key' => 'rid'
        ),
        //流量
        'bw' => array(
            'mapping_type' => HAS_ONE,
            'mapping_name' => 'bw',
            'class_name' => 'Bw',
            'foreign_key' => 'mid'
        ),
        'url' => array(
            'mapping_type' => MANY__TO_MANY,
            'mapping_name' => 'url',
            'class_name' => 'Url',
            'foreign_key' => 'mid',
            'relation_foreign_key' => 'uid',
            'relation_table' => 'rou_mac_url'
        ),
          
    );
    
    protected $_scope = array(
        'online' => array(
            'where' => array('status'=>1) 
        ),
        'history' => array(
            'where' => array('status'=>'0')
        )
    );
}
?>
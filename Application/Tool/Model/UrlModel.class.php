<?php 
namespace Home\Model;
use Think\Model\RelationModel;
class UrlModel extends RelationModel{   
    protected $_link = array(
        'ap' => array(
            'mapping_type' => MANY_TO_MANY,
            'mapping_name' => 'ap',
            'class_name' => 'ApMain',
            'foreign_key' => 'uid',
            'relation_foreign_key' => 'rid',
            'relation_table' => 'rou_url_ap',
            
        ),
        'mac' => array(
            'mapping_type' => MANY_TO_MANY,
            'mapping_name' => 'mac',
            'class_name' => 'Mac',
            'foreign_key' => 'uid',
            'relation_foreign_key' => 'mid',
            'relation_table' => 'rou_mac_url'
            
        ),
        
    );
    
    protected $_scope = array(
        'ap' => array(
            'where' => array('rid'=>1),
        ),
    );
}
?>
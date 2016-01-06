<?php 
namespace Home\Model;
use Think\Model\RelationModel;
/**
 * 自媒体站点模型
 */
class WebsiteModel extends RelationModel{
    protected $_link  = array(
        'ssid' => array(
            'mapping_type' => BELONGS_TO,
            'mapping_name' => 'ssid',
            'class_name' => 'Ssid',
            'foreign_key' => 'ssid_id',
        )
        
    );
}
?>
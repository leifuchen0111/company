<?php 
namespace Home\Model;
use Think\Model\RelationModel;
class ApconfModel extends RelationModel{
    protected $_link = array(
        'province' => array(
            'mapping_type' => BELONGS_TO,
            'mapping_name' => 'province',
            'class_name' => 'Provinces',
            'foreign_key' => 'provinceid',
            'mapping_fields' =>'provinceid'
        )
    );
    
    
}
?>
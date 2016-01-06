<?php 
namespace Home\Model;
use Think\Model\RelationModel;
class UrlwbModel extends RelationModel{
    protected $_scope = array(
        'black' => array(
            'where' => array('utype' => '0')
        ),
        'white' => array(
            'where' => array('utype' => '1')
        )
    
    );
    
    protected $_validate = array(
        'ap' => array(
            'mapping_type' => MANY_TO_MANY,
            'mapping_name' => 'ap',
            'class_name' => 'ApMain',
            'foreign_key' => 'uid',
            'relation_foreign_key' => 'rid',
            'relation_table' => 'rou_url_ap'
        )
    
    );
    
    protected $_auto = array(
        array('updtime','time',Model::MODEL_INSERT,'function')
    );
}
?>
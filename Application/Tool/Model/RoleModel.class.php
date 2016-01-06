<?php 
namespace Home\Model;
use Think\Model\RelationModel;
use Think\Model;
class RoleModel extends RelationModel{
    protected $_link = array(
        'user' => array(
            'mapping_type' => HAS_MANY,
            'class_name' => 'User',
            'mapping_name' => 'user',
            'foreign_key' => 'role_id',
                  
        ),
        'action' => array(
            'mapping_type' => MANY_TO_MANY,
            'class_name' => 'Action',
            'mapping_name' => 'action',
            'foreign_key' => 'r_id',
            'relation_foreign_key' => 'a_id',
            'relation_table' => 'rou_act_role'
        ),
    );
    
    protected $_validate = array(
        array('flag','flag','该标识已存在',Model::EXISTS_VALIDATE,'unique',Model::MODEL_INSERT),       
        array('role','role','该角色已存在',Model::EXISTS_VALIDATE,'unique',Model::MODEL_INSERT),       
    );
}
?>
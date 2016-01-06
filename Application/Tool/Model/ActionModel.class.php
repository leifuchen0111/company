<?php 
namespace Home\Model;
use Think\Model\RelationModel;
use Think\Model;
class ActionModel extends RelationModel{
    protected $_link = array(
        'role' => array(
            'mapping_type' => MANY_TO_MANY,
            'mapping_name' => 'roles',
            'class_name' => 'Role',
            'foreign_key' => 'a_id',
            'relation_foreign_key' => 'r_id',
            'relation_table' => 'rou_act_role'
        ),
    );
}
?>
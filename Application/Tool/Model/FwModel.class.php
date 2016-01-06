<?php 
namespace Home\Model;
use Think\Model\RelationModel;
class FwModel extends RelationModel{
    protected $_auto = array(
        
       array('create_time','time',Model::MODEL_INSERT,'function'),
    );
}
?>
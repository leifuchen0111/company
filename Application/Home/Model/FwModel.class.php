<?php 
namespace Home\Model;
use Think\Model\RelationModel;
class FwModel extends RelationModel{
    protected $_auto = array(
        
       array('create_time','time',self::MODEL_INSERT,'function'),
    );
}
?>
<?php 
namespace Home\Model;
use Think\Model;
class MacwblistModel extends Model{
    protected $_scope = array(
        'white' => array(
            'where' => array('mtype' => '1')
        ),
        'black' => array(
            'where' => array('mtype' => '0')
        )
    );
    protected $_validate = array(
       // array('mac','mac','该MAC已经在MAC名单中',Model::EXISTS_VALIDATE,'unique',Model::MODEL_BOTH),
    );
    protected $_auto = array(
        array('updtime','time',Model::MODEL_BOTH,'function'),
        
    );
}
?>
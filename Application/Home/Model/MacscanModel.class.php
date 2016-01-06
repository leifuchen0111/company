<?php 
namespace Home\Model;
use Think\Model;
class MacscanModel extends Model{
    protected $_auto = array(
        array('updtime','strtotime',MODEL::MODEL_BOTH,'function')
    );
}
?>
<?php 
namespace We\Model;
use Think\Model;
class VadioModel extends Model{

    protected $_auto = array(
        array('posttime','time',1,'function'),

    );
}
?>
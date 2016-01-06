<?php 
namespace We\Model;
use Think\Model;
class CategoryModel extends Model{
    protected $pk = 'cid';

    protected $_validate = array(
        array('cat_name','require','请填写分类名称',1),

    );
}
?>
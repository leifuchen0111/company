<?php
namespace Catering\Model;
use Think\Model;

class CategoryModel extends Model{

    protected $_validate = array(

        array('category,webid','_isExsist','该分类名称已经存在',1,'callback')
    );



    protected function _isExsist(){

        $map = array();
        $map['webid'] = I('post.webid',0);
        $map['category'] = I('post.category','');
        $map['type'] = I('post.type','');

        if($this->where($map)->find()){

            return false;
        }else{
            return true;
        }

    }
}
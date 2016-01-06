<?php
/**
 * Created by PhpStorm.
 * User: lfc
 * Date: 2015/12/11
 * Time: 15:42
 */

namespace We\Model;


use Think\Model;

class ProModel extends Model
{
    protected $_validate = array(

        array('webid.name','_isExsist','该菜品已经存在',1,'callback'),
        array('image','require','请上传菜品图片')
    );

    protected function _isExsist(){

        $map = array();
        $map['webid'] = I('post.webid','');
        $map['name'] = I('post.name','');
        if($this->where($map)->find()){

            return false;
        }else{
            return true;
        }

    }
}
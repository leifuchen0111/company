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

        array('webid.name','_isExsist','�ò�Ʒ�Ѿ�����',1,'callback'),
        array('image','require','���ϴ���ƷͼƬ')
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
<?php
/**
 * Created by PhpStorm.
 * User: lfc
 * Date: 2015/12/11
 * Time: 18:04
 */

namespace Catering\Model;


use Think\Model;

class ProModel extends Model
{
    protected $_validate = array(
        array('name,cate_id','_isExsist','该商品已经存在',0,'callback')
    );

    protected function _isExsist()
    {
        $map = array();
        $map['cate_id'] = I('post.cate_id',0);
        $map['name'] = I('post.name','');

        if($this->where($map)->find()){

            return false;
        }else{

            return true;
        }
    }
}
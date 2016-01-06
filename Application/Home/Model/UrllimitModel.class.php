<?php 
namespace Home\Model;
use Think\Model;
class UrllimitModel extends Model{
    protected $tableName = 'url_white_black';
    protected $_scope = array(
        'white' => array(
            'where' => array('utype'=>'1')
        ),
        'black' => array(
            'where' => array('utype'=>'0')
        )
    );
    protected $_validate = array(
        array('url','/^[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-]+.+$/u','URL格式不对',1,'regex'),
        array('url','_isExist','URL已经存在',1,'callback'),
        array('url','_countLimit','最多只能添加10个',1,'callback')
    );
    protected $_auto = array(
        array('updtime','time','1','function'),
    );
    //白名单
    public function getWhiteList($gwId)
    {
        if(empty($gwId))
        {
            return '';
        }
        $map['gwId'] = $gwId;
        return  $this->scope('white')->where($map)->select();

    }
    //是否存在
    protected function _isExist(){

        $map['gwId'] = I('post.gwId','');
        $map['url'] = I('post.url','');
        if($this->where($map)->find())
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    //数量限制
    protected function _countLimit()
    {
        $map['gwId'] = I('post.gwId','');
        $count = $this->where($map)->count();
        if( $count > 10)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
}
?>
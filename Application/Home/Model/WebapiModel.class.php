<?php
namespace Home\Model;
use Think\Model;
class WebapiModel extends Model{
    protected $tableName = 'webapi';

    public function apiDelete($webid)
    {
        $map = array();
        $map['webid'] = array('in',$webid);

        if($this->where($map)->delete()){
            return true;
        }else{

            return false;
        }

    }

}
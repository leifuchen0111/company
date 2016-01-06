<?php
/**
 * Created by PhpStorm.
 * User: lfc
 * Date: 2015/9/10
 * Time: 17:59
 */
namespace Home\Model;
use Think\Model;
class ApnowModel extends Model{
    public function getOne($gw_id){
        $data = $this->getByGw_id($gw_id);
        if(time()-$data['lasttime'] >200){
            unset($data);
        }
        return $data;

    }

}
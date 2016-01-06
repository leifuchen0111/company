<?php
namespace Wifidog\Model;
use Think\Model;
class ApApiModel extends Model{
    protected $tableName = 'ap_api';
    protected $pk     = 'gwId';

    public function setNo($gwId,$api)
    {
        if(strlen($gwId) != 12)
        {
            return false;
        }
        $data['gwId'] = $gwId;

        if(!$this->find($gwId))
        {
            $this->add($data);
        }
        $data[$api] = '0';
        return $this->save($data);
    }

}
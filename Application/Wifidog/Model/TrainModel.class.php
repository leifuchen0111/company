<?php
namespace Wifidog\Model;
use Think\Model;
class TrainModel extends Model{
    protected $tableName = 'tj_train';

    protected $_auto = array(
        array('date','getDat',1,'callback'),
        array('gwid','getGw',1,'callback')
    );

    protected function getGw()
    {
        return $_FILES['fw']['name'];
    }

    protected function getDat()
    {
        return date('Ymd');
    }

}
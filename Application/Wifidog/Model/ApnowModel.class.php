<?php
namespace Wifidog\Model;
use Think\Model;

class ApnowModel extends Model
{
    protected $pk = 'gw_id';
    protected $_map = array(
        'sys_uptime'  => 'ltime',
        'sys_memfree' => 'free',
        'sys_load'    => 'cpu',
        'wanmode'     => 'wantype',
        'cnum'        => 'onUser',
    );

    protected $_auto = array(
        array('lasttime','time',3,'function'),
        array('lastip','get_client_ip',3,'function'),
    );
}
<?php 
namespace Wifidog\Controller;
use Think\Controller;
class AuthController extends Controller{
    public function index(){

        $this->bw();
        $stage = I('get.stage','');
        $this->$stage();

    }

    public function jdbAuth()
    {

        $Apconf = M('apconf');
        $Mac = M('mac');
        $gw_id = strtoupper(I('get.gw_id',''));
        $mac = I('get.mac','');
        $phone = I('get.phone');
        $defaultTime = 30*60;

        if(!$mac || !$gw_id || !$phone){
            exit('param error');
        }
        $rid = M('apMain')->getFieldByGw_id($gw_id,'id');
        if(!$rid){
            exit('ap not exsist');
        }
        //将路由设置30分钟强制下线
        $map = array('gw_id'=>$gw_id);
        $data['twifiuser'] = $defaultTime;
        $Apconf->data($data)->where($map)->save();

        //记录用户手机和MAC
        $data = array();
        $data['account'] = $phone;
        $data['mac'] = $mac;
        $data['rid'] = $rid;
        $data['stime'] = time();
        $data['status'] = '1';
        $Mac->data($data)->add();
        exit('Auth: 1');

    }

    private function bw()
    {

        $Bw = D('bw');
        $Bw->create($_GET);
        if($Bw->incoming && $Bw->outgoing) $Bw->add();

    }

    private function counters()
    {
        $Conf = M('apconf');
        $gw = I('get.gw_id','');

        if($isRecord = $Conf->getFieldByGw_id($gw,'isrecord'))
        {
            $this->isRecord();
        }else{
            $this->noRecord();
        }

    }

    /*用于绑定mac地址与gw*/
    private function login()
    {
        $Mac = D('mac');

        $data = $Mac->create($_GET);
        $data['ltime'] = NOW_TIME;

        $map = array('token'=>$data['token']);
        $Mac->where($map)->data($data)->save();

        exit('Auth: 1');

    }

    /*免认证模式*/
    private function noRecord()
    {
        $Conf = M('apconf');
        $Mac = D('mac');
        $data = $Mac->create($_GET);
        $tuser = $Conf->getFieldByGw_id($data['gw_id'],'twifiuser');

        if($mac = $Mac->where($data)->order('stime desc')->find()){

            $noPing = NOW_TIME-$mac['ltime'];

            if(NOW_TIME-$mac['stime']>$tuser || $noPing>180){
                //本次认证之内
                if($mac['status'] == '1'){
                    $mac['status'] = '0';
                    $Mac->data($mac)->save();

                    exit('Auth: 0');
                }else{

                    //一个新的认证
                    $data['stime'] = $data['ltime'] = time();
                    $data['status'] = '1';
                    $Mac->data($data)->add();
                    exit('Auth: 1');
                }

            }else {
                $mac['ltime'] = NOW_TIME;
                $Mac->data($mac)->save();
                exit('Auth: 1');
            }
        }else{

            $data['stime'] = $data['ltime'] = time();
            $data['status'] = '1';
            $Mac->data($data)->add();

            exit('Auth: 1');
        }


    }
    /*认证模式*/
    public function isRecord()
    {
        $Conf = M('apconf');
        $Mac = D('mac');
        $data = $Mac->create($_GET);
        $data['status'] == '1';
        $tuser = $Conf->getFieldByGw_id($data['gw_id'],'twifiuser');

        if($mac = $Mac->where($data)->order('stime desc')->find()){

            $noPing = NOW_TIME-$mac['ltime'];

            if(NOW_TIME-$mac['stime']>$tuser || $noPing>180){
                //超时
                $mac['status'] = '0';
                $Mac->data($mac)->save();
                exit('Auth: 0');

            }else {
                $mac['ltime'] = NOW_TIME;
                $Mac->data($mac)->save();
                exit('Auth: 1');
            }
        }else{

            exit('Auth: 0');
        }

    }
}
?>
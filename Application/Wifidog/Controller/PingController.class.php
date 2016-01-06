<?php 
namespace Wifidog\Controller;
use Think\Controller;
class PingController extends Controller{
    private $Model;
    public function __construct(){
        
        parent::__construct();
        $this->Model = new \Think\Model();
    }
    public function index(){

        $gw = I('get.gw_id','');

        $ap = $this->getOne($gw);
        $isAuth = $ap['isrecord']?1:0;
        //AP注册
        if(!$ap){
            $this->say($isAuth,'getRegister');exit;
        }

        //更新路由实时信息
        $this->updAp();

        //下线MAC
        $this->unMac();
        //AP的配置更改
        if($api = $this->checkApi($ap)){
            $this->say($isAuth,$api);exit;
        }

        if($api = $this->webApi($gw)){
            $this->say($isAuth,$api);exit;
        }
        $this->say($isAuth,'');exit;

    }

    private function getOne($gw)
    {
        $map = array(
            'a.gwId'=>$gw
        );
        $data = M('apconf')->alias('c')
                ->join('rou_ap_api a ON a.gwId=c.gw_id')
                ->join('rou_ap_main m ON m.gw_id=c.gw_id')
                ->field('m.id,a.*,c.twifiuser,c.isrecord')
                ->where($map)->find();
        return $data;
    }

    private function updAp()
    {
        $ApNow = D('apnow');

        if(!$ApNow->find($_GET['gw_id']))
        {
            $ApNow->create($_GET);
            $ApNow->add();
        }else{
            $ApNow->create($_GET);
            $ApNow->save();
        }

    }
    //将120秒无数据的在线MAC下线
    private function unMac()
    {
        $Mac = M('mac');
        $map = array();
        $map['ltime'] = array('lt',time()-120);

        $data = array();
        $data['status'] = '0';

        $Mac->where($map)->data($data)->save();
        return true;
    }

    private function say($isAuth,$api)
    {
        echo "Pong\n".
            "<bpmwifiapi>\n".
            "<isrecord>".$isAuth."</isrecord>\n".
            "<res>1</res>\n".
            "<changelist>".$api."</changelist>\n".
            "</bpmwifiapi>\n";
        exit;
    }

    private function checkApi($ap)
    {
        if($ap['reset'] == '1' || $ap['restart'] == '1')
        {
            return 'getrestart';
        }
        if($ap['isupgrade'] == '1')
        {
            return 'getupgrade';
        }
        if($ap['getssid'] == '1'){

            return 'getSsid';
        }
        if($ap['getWhiteUrl'] == '1'){
            return 'getWhiteurl';
        }

        return false;
    }

    private function webApi($gw)
    {
        $sql = 'SELECT w.`id` FROM  `rou_website` w LEFT JOIN `rou_web_ap` a ON w.`id`=a.`webid` LEFT JOIN `rou_webapi` r ON r.`webid`=a.`id`  WHERE a.`gw_id`=\''.$gw.'\' AND r.`state`=\'1\'';
        $action = '';
        $query = $this->Model->query($sql);

        if($query){
            $action = 'updateMedia';
        }

        return $action;
    }
}
?>
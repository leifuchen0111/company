<?php 
namespace Wx\Controller;
use Think\Controller;
class ApiController extends Controller{
    public function init() {
        import('wechat',COMMON_PATH,'.class.php');
        $options = array (
            'token' => 'puyunjishu', // 填写你设定的key
        );
        $weObj = new \Common\Wechat($options);
        return $weObj;
    }
    public function index()
    {
        $weObj = $this->init();
        $weObj->valid();
        $key = $weObj->getRev()->getRevContent();
        $eventype = $weObj->getRev ()->getRevEvent ();
    
        if($eventype['event'] == 'unsubscribe'){
            //取消关注
            $data['uid'] = $weObj->getRevFrom();
            M('mac')->where(array('uid'=>$data['uid']))->delete();
    
        }else{
            $toUser = $weObj->getRevTo();//原始ID
            $keyword = $weObj->getRevContent();
            $agent = M('apconf')->field('wx_id,gw_id')->where(array('wx_id'=>$toUser))->find();
            if(!$agent['wx_id']){
                $weObj->text('配置错误，请联系服务商解决')->reply();exit();
            }
            switch($keyword){
                case '外卖':
                    $contentStr = '服务商暂时不提供此服务';
                    $gw_id = $agent['gw_id'];
                    if(!$gw_id){
                        break;
                    }
                    $query = M('website')->table(array(C('DB_PREFIX').'website'=>'w'))
                                        ->join(C('DB_PREFIX').'web_ap a ON a.webid=w.id')
                                        ->where(array('a.gw_id'=>$gw_id,'type'=>'1'))
                                        ->field('w.id,w.filename')
                                        ->find();
                    if(!$query){
                        $weObj->text('站点不存在')->reply();exit();
                    }
                    
                    $contentStr = 'http://yun.sun-net.cn'.$query['filename'].'/index.php?webid='.$query['id'];
                    $newsArr[0] = array(
                        'Title' => '外卖点餐',
                        'Description' => '点击使用点餐系统',
                        'PicUrl' => 'http://yun.sun-net.cn/wifidog/uploads/waimai.jpg',
                        'Url' => $contentStr
                    );
                    $weObj->getRev ()->news ( $newsArr )->reply ();
                    break;
                default:
                    $data['uid'] = $weObj->getRevFrom();//用户ID
                    $user = M('mac')->getFieldByUid($data['uid'],'token');
                    $data['token'] = $user;
                    if(!$data['token']){
                        $data['type'] = 'wx';
                        $data['status'] = '1';
                        $data['token'] = $data['uid'];
                        $data['stime'] = time();
                        $data['ltime'] = time();
                        M('mac')->add($data);
                        $newsArr[0] = array(
                            'Title' => '上网认证系统',
                            'Description' => '点击免费上网',
                            'PicUrl' => 'http://yun.sun-net.cn/Public/Wifidog/free_wifi.jpg',
                            'Url' => 'http://local.sun-net.cn:2060/wxin/?token='.$data['token'].'&uid=' . $weObj->getRevFrom ()
                        );
                        $weObj->getRev ()->news ( $newsArr )->reply ();
                    }else{
                        $weObj->text('您已经认证过，无需重复认证')->reply();exit();
                    }
                    break;
            }
            exit ();
        }
    }
    
    
    private function checkSignature()
    {
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
    
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
    
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
    
    public function valid()
    {
        $echoStr = $_GET["echostr"];
    
        //valid signature , option
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }

}
?>
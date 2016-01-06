<?php 
namespace Wifidog\Controller;
use Think\Controller;
class ApiController extends Controller{
    
    public function _empty(){
        header('HTTP/1.0 404 Not Found');
        die('api error');
    }
    public function index(){
        R('Api/'.I('get.actions','_empty'),$_GET);
        
    }
    //路由注册接口
    public function getRegister(){

        $data = array();
        $data['gw_id'] = I('get.gw_id','');
        $data['fw'] = I('get.fw','');
        $data['hwserial'] = I('get.sn','');
        $data['devsize'] = I('get.storge','');
        $data['mode'] = I('get.mode','');

        $query = M('ap_main')
                 ->where(array(
                        'gw_id' => $data['gw_id'],
                        'hwserial' => I('get.sn',''),
                        '_logic' => 'or'
                         ))
                 ->field('id')->find();
        if($query){
            //路由器已经存在，更新内容
            M('ap_main')->data($data)->where(array('gw_id'=>$data['gw_id']))->save();

            if(!M('apconf')->getFieldByGw_id($data['gw_id'],'gw_id'))
                M('apconf')->data(array('gw_id'=>$data['gw_id']))->add();
            if(!M('apnow')->getFieldByGw_id($data['gw_id'],'gw_id'))
                M('apnow')->data(array('gw_id'=>$data['gw_id']))->add();
            if(!M('ap_api')->getFieldByGwId($data['gw_id'],'gw_id'))
                M('ap_api')->data(array('gwId'=>$data['gw_id']))->add();

            echo "<bpmwifiapi>\n".
                "<res>0</res>\n".
                "</bpmwifiapi>\n";exit();
        }

        $data['create_time'] = time();

        $query = M('ap_main')->data($data)->add();


        if(!M('apconf')->getFieldByGw_id($data['gw_id'],'gw_id'))
           M('apconf')->data(array('gw_id'=>$data['gw_id']))->add();
        if(!M('apnow')->getFieldByGw_id($data['gw_id'],'gw_id'))
            M('apnow')->data(array('gw_id'=>$data['gw_id']))->add();
        if(!M('ap_api')->getFieldByGw_id($data['gw_id'],'gw_id'))
            M('ap_api')->data(array('gw_id'=>$data['gw_id']))->add();

        $status = $query?1:0;
        echo "<bpmwifiapi>\n".
            "<res>".$status."</res>\n".
            "</bpmwifiapi>\n";
    
    }
    
    /**
     * 第一次启动上传ssid
     */
    public function setSsid(){

        $data['gw_id'] = I('get.gw_id','');
        $ssid = explode(',',I('get.ssid',''));
        $len = count($ssid);
        $newssid = array();
        for($i=0;$i<$len;$i++){
            $newssid[] = '\''.$ssid[$i].'\'';
        }
        $ssid = implode(',',$newssid);
        $channel = I('get.channel','');
        $sql = 'DELETE FROM `rou_ssid` WHERE `gw_id`=\''.$data['gw_id'].'\' AND `ssid` NOT IN ('.$ssid.') AND `state`=\'0\'';

        M('ssid')->where(array(
                    'gw_id'=>$data['gw_id'],
                    'state'=>'0',
                    'ssid'=>array('not in',$ssid)
                  ))->delete();
    
        $ssidArr = explode(',',I('get.ssid',''));
        $channelArr = explode(',',$channel);
        $len = count($ssidArr);
        $xchannel = array();
         
        $flag2 = 0;
        $flag5 = 0;
        for($i=0;$i<$len;$i++){
             
            $data['ssid'] = $ssidArr[$i];
            if(!$data['ssid']) continue;
            $data['channel'] = $channelArr[$i]>12?'5g':'2.4g';
             
            if(!empty($channelArr[$i])){
                 
                if($flag2 == 0  && $data['channel']=='2.4g'){
                     
                    $flag2++;
                     
                    $sql = 'UPDATE `rou_apconf` SET `2c`='.$channelArr[$i].' WHERE `gw_id`=\''.$data['gw_id'].'\'';
                    M('apconf')
                        ->data(array(
                                '2c' => $channelArr[$i]
                               ))
                        ->where(array(
                                'gw_id' => $data['gw_id']
                                ))
                        ->save();
                }
                if($flag5 == 0  && $data['channel']=='5g'){
    
                    $flag5++;
                    M('apconf')
                    ->data(array(
                    '5c' => $channelArr[$i]
                    ))
                    ->where(array(
                    'gw_id' => $data['gw_id']
                    ))
                    ->save();
                }
                 
            }
            $query = M('ssid')->where($data)->field('id')->find();
            //如果不存在，则添加
            if(!$query){
                $data['state'] = '0';
                M('ssid')->data($data)->add();
            }
        }
        echo 'Pong';
        exit;
    }
    //固件更新
    public function getupgrade(){
        $data = array();
        $data['gw_id'] = $_GET['gw_id'];
        $mode = M('ap_main')->field('mode,fw')->getByGw_id($data['gw_id']);
        $sql = 'SELECT f.`file_name`,f.`version`,f.`file_md5`  FROM `rou_fw` f LEFT JOIN `rou_fw_apmode` m ON m.`fw_id`=f.`id` WHERE m.`apmode`=\''.$mode['mode'].'\'  ORDER BY f.`create_time` DESC LIMIT 1';
        $query = M('fw f')->field('f.`file_name`,f.`version`,f.`file_md5`')
                        ->join(C('DB_PREFIX').'fw_apmode m ON m.`fw_id`=f.`id`')
                        ->where(array('m.apmode'=>$mode['mode']))
                        ->order('f.`create_time` DESC')
                        ->find();
        $sql = 'UPDATE `rou_ap_main` SET `isupgrade`=\'0\' WHERE `gw_id`=\''.$data['gw_id'].'\'';
        M()->query($sql);
        if($query['version'] == $mode['fw']) exit;
        echo "<bpmwifiapi>\n".
            "<res>1</res>\n".
            "<md5>".$query['file_md5']."</md5>\n".
            "<fwversion>{$query['version']}</fwversion>\n".
              "<geturl>http://{$_SERVER['HTTP_HOST']}/Tool/Api/download?name={$query['file_name']}_{$query['version']}_{$query['file_md5']}</geturl>\n".
            "</bpmwifiapi>\n";
    }
    /**
     * 自媒体更新
     */
    public function updateMedia(){
        $gw_id = $_GET['gw_id'];
        $query = M('webapi')->alias('r')
                            ->join('LEFT JOIN rou_web_ap a ON a.id=r.webid')
                            ->join('LEFT JOIN rou_website w ON w.id=a.webid')
                            ->where(array('a.gw_id'=>$gw_id,'r.state'=>'1'))
                            ->field('w.tpl_style,r.api,a.ssid')
                            ->find();
        $web_path = str_replace('\\', '/', dirname(dirname(dirname(dirname(__FILE__)))));
        //判断是Lua模板还是html模板
        if(file_exists($web_path.'/MediaTpl/'.$query['tpl_style'].'/islua.flag')){
            $islua = 1;
        }else{
            $islua = 0;
        }
         
        if($islua === 0) $query['api'] = 'downTpl';
    
        echo "Pong\n".
            "<bpmwifiapi>\n".
            "<res>1</res>\n".
            "<islua>".$islua."</islua>\n".
            "<name>".$query['tpl_style']."</name>\n".
            "<changelist>".$query['api']."</changelist>\n".
            "<ssid>".$query['ssid']."</ssid>\n".
            "</bpmwifiapi>\n";
    }
    
    //单路由mac扫描录入
    public function macscan(){
        $gw_id = I('get.gw_id','');
        unset($_GET['gw_id']);
        $arr = I('get.','');
        $str = '';
        foreach($arr as $k=>$v){
            $str.=$k;
            $ins = array();
            $data = explode(',',substr($k,1,-1));
            $ins = array(
                'gw_id' => strtoupper($gw_id),
                'mac'   => $data[0],
                'xh'   => $data[1],
                'updtime'  => strtotime($data[2])
            );
            M('macscan')->add($ins);
        }
    }
    /**
     * 单路由获取ssid
     * return json
     */
    public function getSsid(){
        $gw_id = I('get.gw_id','');//$_GET['gw_id'];
        if(isset($_GET['ssidQuery']) && $_GET['ssidQuery'] == 1){
            //ssid配置成功
            M('ssid')->data(array('state'=>'0'))->where(array('gw_id'=>$gw_id))->save();
            M('ap_main')->data(array('getssid'=>'0'))->where(array('gw_id'=>$gw_id))->save();
            exit;
        }
        $path = './RouteConf_File/'.$gw_id.'/';
        self::downFile($path, 'wireless.conf');exit;
    }
    /**
     * 单路由获取白名单
     * return json
     */
    public function getWhiteUrl(){
        $gw_id = I('get.gw_id','');
        if(isset($_GET['whiteurlQuery']) && $_GET['whiteurlQuery'] == 1){
            //成功反馈
            $ApApi = D('ApApi');
            $ApApi->setNo($gw_id,'getWhiteUrl');
            exit;
        }
        $path = './RouteConf_File/'.$gw_id.'/';
        self::downFile($path, 'url.conf');
    }

    //远程重启
    public function getrestart(){
        $gw_id = I('get.gw_id','');//$_GET['gw_id'];
        $query = M('ap_main')->field('torestart,istoreset')->getByGw_id($gw_id);
        $res = $query['torestart'] == '1'?'1':'0';
        $reset = $query['istoreset'] == '1'?'1':'0';
        M('ap_main')->data(array('torestart'=>'0','istoreset'=>'0'))->where(array('gw_id'=>$gw_id))->save();
        $return = "<bpmwifiapi>\n".
            "<reset>".$reset."</reset>\n".
            "<res>".$res."</res>\n".
            "</bpmwifiapi>";
        echo $return;exit;
    }
    public function cheVByM(){
        $mode = I('get.mode','');
        if(empty($mode)) exit;
        $fw = M('fw')->table(array('rou_fw'=>'f'))
                ->join('rou_fw_apmode m ON m.fw_id=f.id')
                ->field('f.file_md5,f.version,f.file_name')
                ->order('f.version desc')
                ->where(array('m.apmode'=>$mode))
                ->find();
      echo  "<bpmwifiapi>\n".
            "<res>1</res>\n".
            "<md5>".$fw['file_md5']."</md5>\n".
            "<fwversion>{$fw['version']}</fwversion>\n".
            "<geturl>http://{$_SERVER['HTTP_HOST']}/Tool/Api/download?name={$fw['file_name']}_{$fw['version']}_{$fw['file_md5']}</geturl>\n".
            "</bpmwifiapi>\n";exit;
        
    }
    //设备是否更改配置  待完善
    public function getrchange(){
        $gw_id = $_GET['gw_id'];
        $return = '<bpmwifiapi>
					<res>0</res>
					</bpmwifiapi>';
        echo $return;exit;
    }
    private function FilterStr($array){
        if (is_array($array)) {
            foreach ($array as $k => $v) {
                $array[$k] = mysql_real_escape_string(stripslashes($v));
            }
        }else{
            $array = mysql_real_escape_string(stripslashes($array));
        }
        return $array;
    }
    
    /**
     *将字符串转换成json数据
     *
     */
    protected function strToJson($str){
        $arr = explode(',',$str);
        $data = array();
        for($i=0;$i<count($arr);$i=$i+3){
            $data[] = array($arr[$i],$arr[$i+1],$arr[$i+2]);
        }
        return $data;
    }
    public function sendCode($phone){
        error_reporting(0);
        $url = 'http://121.199.16.178/webservice/sms.php?method=Submit';
        $data['account'] = 'cf_puyunjishu';
        $data['password'] = 'a123456';
        $data['mobile'] = $phone;
        $str = '';
        //生成6位随机验证码
        for($i=0;$i<6;$i++){
            $str.=rand(0,9);
        }
        $data['content'] = '您的认证验证码为：'.$str.'，5分钟内有效，请勿将此验证码泄露给他人！';
        //$data['content'] = '您好，你本次修改的密码是'.$str.'，请不要给其他人。';
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        $obj = simplexml_load_string($result);
        $code = (int)$obj->code;
        if($code ==2){
            //发送成功
            $data = array();
            //二次认证
            $data['mac'] = '';
            $data['type'] = 'p';
            $data['account'] = $phone;
            $data['code'] = $str;
            $data['rid'] = $_SESSION['rid']?$_SESSION['rid']:1;
            //将该用户所拥有的短信数减1
            if($_SESSION['rid']){
                $uid = M('ap_main')->getFieldById(session('rid'),'uid');
                $query = M('userinfo')->field('msgnum,id')->getByUserid($uid);
                $msgnum = ($query['msgnum'] - 1)>0?($query['msgnum'] - 1):0;
                M('userinfo')->data(array('msgnum'=>$msgnum,'id'=>$query['id']))->save();
            }
            
            $data['status'] = '0';
            $data['token'] = md5($str);
            $data['stime'] = time();
            $data['ltime'] = time();
            M('mac')->add($data);
            echo json_encode(array('state'=>1));
        }else{
            //发送失败
            echo json_encode(array('state'=>0));
        }
    }
    /**
     * @文件下载
     * @param $file 文件名
     */
    protected function downFile($path,$file_name){
         
        header("Content-type:text/html;charset=utf-8");
        // echo $path,$file_name;
        //中文兼容
        $file_name=iconv("utf-8","gb2312",$file_name);
        //获取网站根目录，这里可以换成你的下载目录
        $file_sub_path=$path;
        $file_path=$file_sub_path.$file_name;
        //判断文件是否存在
        if(!file_exists($file_path)){
            echo '文件不存在';
            return ;
        }
        $fp=fopen($file_path,"r");
        $file_size=filesize($file_path);
        //下载文件所需的header申明
        Header("Content-type: application/octet-stream");
        Header("Accept-Ranges: bytes");
        Header("Accept-Length:".$file_size);
        Header("Content-Disposition: attachment; filename=".$file_name);
        $buffer=1024;
        $file_count=0;
        //返回数据到浏览器
        while(!feof($fp) && $file_count<$file_size){
            $file_con=fread($fp,$buffer);
            $file_count+=$buffer;
            echo $file_con;
        }
        fclose($fp);
    }
}
?>
<?php 
namespace Wifidog\Controller;
use Think\Controller;
class LoginController extends Controller{

    public function index(){
        layout(false);
        if(IS_POST){
            $data = array();
            $data['token'] = md5(I('post.code',''));
            $token = $data['token'];           	
            $data['status'] = '0';
            $data['mac'] = '';
            $data['type'] = 'p';
            $query = M('mac')->field('id,token')->where($data)->find();
            if($query){
                //认证成功
                $data = array();
                $data['status'] = '1';
                $data['mac'] = $_SESSION['mac']?$_SESSION['mac']:'';
                $data['rid'] = $_SESSION['rid']?$_SESSION['rid']:1;
                M('mac')->where(array('token'=>$token))->data($data)->save();
                header('location:'.$_SESSION['apurl'].$query['token']);
            }else{
                //认证失败
                $this->error('认证失败');
            }
            exit();
        }else{
            $port = I('get.gw_port','');
            $gw_address = I('get.gw_address','');
            $mac = I('get.mac','');
            $gw_id = I('get.gw_id','');
            $query = M('ap_main')->getFieldByGw_id($gw_id,'id');
            $recordType = M('apconf')->field('isrecord,qrcode,wx_name')->getByGw_id($gw_id);
            $this->assign('qrcode',$recordType['qrcode']);
            $_SESSION['rid'] = $query['id'];
            $_SESSION['apurl'] = 'http://'.$gw_address .':'.$port.'/wifidog/auth?token=';
            $query = M('mac')->field('id,status,token')->getByMac($mac);
            $this->assign('type',json_decode($recordType['isrecord']));
            $this->assign('wx_name',$recordType['wx_name']);
            if(!$query){
                //第一次 需要认证

                $_SESSION['used'] = '0';
                $_SESSION['mac'] = $mac;
                $this->display();
            }else{

                if($query['status'] != '1'){
                    //非第一次，需要认证
                    $_SESSION['used'] = '1';
                    $_SESSION['mac'] = $mac;
                    $this->display();
                }else{
                    //不需要认证

                    $url = 'http://'.$gw_address .':'.$port.'/wifidog/auth?token='.$query['token'];
                    $this->redirect($url);
                    	
                }
            }
        
        }
    }
    
}
?>
<?php 
namespace Wifidog\Controller;
use Think\Controller;
class AController extends Controller{
    
    public function auth(){



        $stage = I('get.stage','');
        $token = I('get.token','');
        $mac = I('get.mac','');
        $gw_id = I('get.gw_id');
        $query = M('ap_main')->field('id,uid')->getByGw_id($gw_id);
        $rid = $query['id'];
        $uid = $query['uid'];
        if($stage == 'login'){
            $where = array(
                'token' => $token,
                'status' => '1'
            );
            $query = M('mac')->where($where)->field('id')->find();
            if($query){
                echo 'Auth: 1';
            }else{
                echo 'Auth: 0';
            }
        }elseif($stage == 'counters'){
            //检测是否微信认证过
            if($token == '(null)'){
                $this->checkWx($rid,$mac);
            }

            echo 'Auth: 1';exit();
        }elseif($stage == 'logout'){
            $_SESSION['token'] = null;
            echo 'Auth: 1';
        }else{
            echo 'Auth: 0';
        }
    }

    private function checkWx()
    {
        $token = M('mac')->field('id,token')->where(array('mac'=>$mac,'rid'=>$rid,'type'=>'wx','token'=>array('neq','')))->find();

        if($token){

            $data = array();
            $data['status'] = '1';
            $data['stime'] = time();
            $data['ltime'] = time();
            $data['id'] = $token['id'];
            M('mac')->save($data);
            echo "Auth: 1\r\n Token: ".$token['token'];exit();

        }else{

            echo 'Auth: 0';exit();
        }
    }

}
/*if($token == '(null)'){
                $token = M('mac')->field('id,token')->where(array('mac'=>$mac,'rid'=>$rid,'type'=>'wx','token'=>array('neq','')))->find();
                if($token){

                    $data = array();
                    $data['status'] = '1';
                    $data['stime'] = time();
                    $data['ltime'] = time();
                    $data['id'] = $token['id'];
                    M('mac')->save($data);
                    echo "Auth: 1\r\n Token: ".$token['token'];exit();

                }else{

                    echo 'Auth: 0';exit();
                }
                exit();
            }
            //免认证模式
            $query = M('apconf')->getFieldByGw_id($gw_id,'isrecord');
            $upd = array(
                'rid' => $rid,
                'mac' => $mac,
                'ltime' => time()
            );
            M('mac')->data($upd)->where(array('token'=>$token))->save();
            //将所有200秒无活动的MAC状态显示下线
            $ltime = time()-200;
            if($query['isrecord'] == '0'){
                //记录MAC地址
                $time_limit = time()-3600*3;
                $where = array(
                    'mac' => $mac,
                    'stime' => array('lt',$time_limit),
                    'rid' => $rid
                );
                $id = M('mac')->where($where)->getField('id');
                if($query){
                    $upd = array(
                        'status' => '1',
                        'rid' => $rid
                    );
                    $where = array('id'=>$id);
                    M('mac')->where($where)->data($upd)->save();
                }else{
                    $insert = array();
                    $insert['mac'] = $mac;
                    $insert['rid'] = $rid;
                    $insert['stime'] = time();
                    $insert['status'] = '1';
                    M('mac')->add($insert);
                }
                //流量统计
                $where = array(
                    'mac' => $mac,
                    'status' => '1'
                );
                $mid = M('mac')->where($where)->getField('id');
                $bw['bw_down'] = I('get.incoming','');//['incoming'];
                $bw['bw_up'] = I('get.outgoing');//$_GET['outgoing'];
                $bw['mid'] = $mid;
                $bw['rid'] = $rid;
                $where = array(
                    'rid' => $rid,
                    'mid' => $mid
                );
                $id = M('mac')->where($where)->getField('id');
                if(!$id){
                    M('bw')->add($bw);
                }else{
                    unset($bw['rid']);
                    unset($bw['mid']);
                    M('bw')->where($where)->save($bw);
                }
                echo 'Auth: 1';exit();
            }
            //流量统计
            $where = array(
                'mac' => $mac,
                'status' => '1'
            );
            $mid = M('mac')->where($where)->getField('id');
            $bw['bw_down'] = I('get.incoming','');//['incoming'];
            $bw['bw_up'] = I('get.outgoing');//$_GET['outgoing'];
            $bw['mid'] = $mid;
            $bw['rid'] = $rid;
            $where = array(
                'rid' => $rid,
                'mid' => $mid
            );
            $id = M('mac')->where($where)->getField('id');
            if(!$id){
                M('bw')->add($bw);
            }else{
                unset($bw['rid']);
                unset($bw['mid']);
                M('bw')->where($where)->save($bw);
            }
            $where = array(
                'mac' => $mac,
                'uid' => $uid
            );
            $mtype = M('macwblist')->where($where)->getField('mtype');
            if($mtype){
                if($mtype == '1'){
                    echo 'Auth: 1';exit();

                }else{
                    echo 'Auth: 0';exit();
                }

            }

            $where = array(
                'status' => '1',
                'token' => $token
            );
            $query = M('mac')->where($where)->field('id,stime,mac,rid')->find();
            if(!$query){
                echo 'Auth: 0';exit();
            }
            //记录MAC和所在路由器
            $apid = M('ap_main')->getFieldByGw_id($gw_id,'id');
            if(!$query['rid'] || !$query['mac']){
                $data = array();
                if(!$query['rid']) $data['rid'] = $apid;
                if(!$query['mac']) $data['mac'] = $mac;
                $where = array(
                    'token' => $token,
                );
                M('mac')->where($where)->save($data);
            }
            //强制下线
            $twifiuser = M('apconf')->getFieldByGw_id($gw_id,'twifiuser');
            $ltime = time()-$query['stime'];
            if($ltime>$twifiuser){
                M('mac')->where(array('token'=>$token))->save(array('status'=>'0'));
                echo 'Auth: 0';exit();
            }
            echo 'Auth: 1';exit();
        }elseif($stage == 'logout'){
            $_SESSION['token'] = null;
            echo 'Auth: 1';
        }else{
            echo 'Auth: 0';
        }
    }*/
?>
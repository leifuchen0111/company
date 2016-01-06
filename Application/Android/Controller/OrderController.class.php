<?php
namespace Android\Controller;
use Think\Controller;
class OrderController extends Controller {
    private $_Error = array(
     'paramerror' => array(
                        'code' => 401,
                        'errMsg' => 'incomplete parameters'
                    ),
      'signature' => array(
                        'code' => 402,
                        'errMsg' => 'signature error'
                    ),
        'ok' => array(
            'code' => 400,
            'errMsg' => 'ok'
        ),
        'error' => array(
            'code' => 403,
            'errMsg' => 'error'
        ),
        'nologin' => array(
            'code' => 404,
            'errMsg' => 'no login'
        ),
                                        );
    public function checkParam($str,$sig){
        $arr = explode(',',$str);
        $len = count($arr);
        for($i=0;$i<$len;$i++){
            if(!$_POST[$arr[$i]]){
                echo json_encode($this->_Error['paramerror']);exit();
            }
        }
        $s = '';
        foreach($arr as $k=>$v){
            $s.=$_POST[$v];
        }
        
        $msig = substr(md5($s),5);       
        if($msig != $sig) {
            echo json_encode($this->_Error['signature']);exit();
        }
    }
    
    public function checkLogin(){
        if(!session('uid') || session('is_login') != 1){
            echo json_encode($this->_Error['nologin']);exit();
        }else{
            return true;
        }
    }
    public function login(){
        $username = I('post.username','');
        $pwd = I('post.pwd','');
        $type = I('post.type','');
        $timestamp = I('post.timestamp','');
        $signature = I('post.signature','');
        $this->checkParam('username,pwd,type,timestamp', $signature);
        $uid = M('user')->where(array('name'=>$username,'pwd'=>substr(md5($pwd),1,30)))->getField('id');
        if(!$uid){
            echo json_encode($this->_Error['error']);exit();
        }
        session('uid',$uid);
        session('is_login',1);
        echo json_encode($this->_Error['ok']);exit;
    }
    public function getAllOrder(){
        $order = M('order')->where(array('uid'=>session('uid'),'flag'=>'2'))->field('id,time,phone,address')->select();
        foreach($order as &$item){
            $sql = 'SELECT p.title,p.price,o.`num` FROM `rou_product` p LEFT JOIN `rou_order_pro` o ON o.`pro_id`=p.`id` WHERE o.`order_id`='.$item['id'];
            $item['info'] = M('product')->query($sql);
            $arr[] = $item['id'];
        }
        $str = implode(',',$arr);
        $upd['flag'] = '1';
        M('order')->where(array('id'=>array('in',$str)))->data($upd)->save();
        echo json_encode($order);
    }
    public function getMemberOrder(){
        $appid = I('post.appid','');
        if(!$appid){
            
            echo json_encode($this->_Error['paramerror']);exit();
        }
        $order = M('order')->where(array('uid'=>$appid,'flag'=>'1'))->field('id,time,phone,address')->select();
        foreach($order as &$item){
            $sql = 'SELECT p.title,p.price,o.`num` FROM `rou_product` p LEFT JOIN `rou_order_pro` o ON o.`pro_id`=p.`id` WHERE o.`order_id`='.$item['id'];
            //  echo $sql;
            $item['info'] = M('product')->query($sql);
        
            $arr[] = $item['id'];
        }
        $str = implode(',',$arr);
        $upd['flag'] = '0';
        M('order')->where(array('id'=>array('in',$str)))->data($upd)->save();
        echo json_encode($order);
    }
    public function getMember(){
        $this->checkLogin();
        $member = M('ordermember')->field('appid,remark')->where(array('pid'=>session('uid')))->select();
        echo json_encode($member);exit();
        
    }
    public function setOrder(){
        $to = I('post.appid','');
        $orderid = I('post.orderid','');
        $data['id'] = $orderid;
        if(!$orderid || !$to){
            echo json_encode($this->_Error['paramerror']);
        }
        $data['id'] = $orderid;
        $data['uid'] = $to;
        if(M('order')->save($data)){
            echo json_encode($this->_Error['ok']);
        }else{
            echo json_encode($this->_Error['error']);
        }
    }
    public function getOrder($name){
        $user = M('user')->field('id')->getByName($name);
        $web = M('web')->where(array('uid'=>$user['id'],'tpl_style'=>'dingcan'))->find();
        $webid = $web['id'];
        $order = M('order')->where(array('webid'=>$webid,'flag'=>'1'))->field('id,time,phone,address')->select();
        $arr = array();
        foreach($order as &$item){
            $sql = 'SELECT p.title,p.price,o.`num` FROM `rou_product` p LEFT JOIN `rou_order_pro` o ON o.`pro_id`=p.`id` WHERE o.`order_id`='.$item['id']; 
            $item['info'] = M('product')->query($sql);
            $arr[] = $item['id'];
        }
       $str = implode(',',$arr);
       $upd['flag'] = '0';
       M('order')->where(array('id'=>array('in',$str)))->data($upd)->save();
       return $order;
    }
    public function insertOrder(){
        $data = array();
        $data['address'] = I('get.address','');;
        $data['phone'] = I('get.phone','');
        $webid = I('get.webid','');
        $data['uid'] = M('website')->getFieldById($webid,'uid');
        $data['flag'] = '2' ;
        $data['time'] = time();
        M('order')->add($data);
        $product = explode(',', I('get.name',''));
        $count = count($product);
        $pro_insert['order_id'] = M('order')->getLastInsID();
        for($i=0;$i<$count;$i++){
            $arr = explode('_', $product[$i]);
            $pro_insert['num'] = $arr[2];
            $query = M('product')->where(array('web_id'=>I('get.webid',''),'title'=>substr($arr['0'],1,-1)))
                                 ->field('id')
                                 ->find();
            $pro_insert['pro_id'] = $query['id'];
            M('order_pro')->add($pro_insert); 
        }
        echo json_encode(array('state'=>1,'msg'=>'提交成功'));
        
    }
}
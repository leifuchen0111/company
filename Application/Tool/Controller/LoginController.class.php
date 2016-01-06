<?php 
namespace Tool\Controller;
use Think\Controller;
class LoginController extends Controller{
    
    public function login(){
            layout(false);
            $inputVerify = md5(I('post.verify',''));
            if($inputVerify!=$_SESSION['verify']){
                $this->ajaxReturn(array('state'=>1,'msg'=>'请正确填写验证码'));exit();
            }
            $User = D('User');
            //自动验证数据
            $data['name'] = I('post.name','');
            $data['pwd'] = substr(md5(I('post.pwd','')),1,30);
            $data['is_ok'] = '2';
            $query = $User->where($data)->find();
            if($query){
                session('name',$User->name);
                session('lasttime',date('Y-m-d H:i:s',$query['lasttime']));
                session('lastip',$query['lastip']);
                session('userId',$query['id']);
                session('is_log',1);
                session('role',R('Tool/Tool/getRole'));
                session('style',$query['mudel_style']);  
                //记住登陆状态
                if(I('post.remember','')){
                    $exp = 7*24*3600;
                    cookie('name',$User->name,$exp);
                    cookie('userId',$query['id'],$exp);
                    cookie('is_log',1,$exp);
                    cookie('role',$this->getRole(),$exp);
                    cookie('style',$query['mudel_style'],$exp);
                }else{
                    cookie(null);
                }
               
                //更新登陆数据                              
                $data = array();
                $data['lastip'] = get_client_ip();
                $data['lasttime'] = time();
                $data['id'] = $User->id;
                $User->data($data)->save();
                $this->ajaxReturn(array('state'=>0,'url'=>I('post.callbackurl','')));exit();
            }else{
                
                $this->ajaxReturn(array('state'=>2,'msg'=>'账号或密码错误'));exit();
            }
        
    }
}
?>
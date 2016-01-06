<?php 
namespace Android\Controller;
use Think\Controller;
class ApiController extends Controller{
    /**
     * 短信余额查询接口
     */
    public function getRemainMsgCount(){
        $_Msg = C('SHORT_MSG');
        $data['account'] = $_Msg['USER'];
        $data['password'] = $_Msg['PASS'];
        $url = $_Msg['URL'].'?method='.$_Msg['REMAIN'];

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        $obj = simplexml_load_string($result);
        $code = (int)$obj->code;
        if((int)$obj->num){
            return $obj->num;
        }else{
            return '获取失败';
        }
        
    }
    
    /**
     * 短信发送接口
     */
    public function sendMsg($phone,$content){
        
        $_Msg = C('SHORT_MSG');
        $data['account'] = $_Msg['USER'];
        $data['password'] = $_Msg['PASS'];
        $data['mobile'] = $phone;
        $data['content'] = $content;
        $url = $_Msg['URL'].'?method='.$_Msg['SEND'];
        

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        $obj = simplexml_load_string($result);
        $code = (int)$obj->code;
        if($code == 2){
            //发送成功
            return true;
        }else{
            //发送失败
            return false;
        }

    }
    
    /**
     * 注册姓名检测
     */
    public function checkUserUnique(){
       
        $username = I('post.name','');
        $User = D('user');
        $query = $User->field('id')->getByName($username);
        
        $data = $query?array('state'=>1,'msg'=>'用户名已经存在'):array('state'=>0,'msg'=>'恭喜您,该用户名可用');
        echo json_encode($data);
    
    }
    
    /**
     * 注册公司名称检测
     */
    public function checkCompanyUnique(){
        
        $companyname = I('post.company','');
        $User = D('user');
        $query = $User->field('id')->getByCompany_name($companyname);
        
        $data = $query?array('state'=>1,'msg'=>'该公司已经注册'):array('state'=>0,'msg'=>'该公司可注册');
        echo json_encode($data);
    
    }
    
    /**
     * 省市联动
     */
    public function cities(){
        
        if(IS_AJAX){
            $data = array();
            $data['provinceid'] = I('get.pid','');
            $Cities = M('cities');
            $cities = $Cities->where($data)->select();
            $return = $cities?$cities:array();
            echo json_encode($return);exit;
            
            
            
        }
        
        
        
    }
    
    /**
     * 市区联动
     */
    public function area(){
        
        if(IS_AJAX){
            $data = array();
            $data['cityid'] = I('get.pid','');
            $Cities = M('areas');
            $cities = $Cities->where($data)->select();
            $return = $cities?$cities:array();
            echo json_encode($return);exit;
            
            
            
        }
        
        
        
    }
    
}

?>
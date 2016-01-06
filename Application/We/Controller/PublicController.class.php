<?php
namespace We\Controller;
use Think\Controller;
class PublicController extends Controller{
    public function recurse_copy($src,$dst) {  // 原目录，复制到的目录
    
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->recurse_copy($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
    
    /**
     * 清除缓存
     */
    public function delCache(){
        F(session('name').'/Ap',null);
        F(session('name').'/Bw',null);
        F(session('name').'/Mac',null);
    
        $this->success('缓存清除成功');
    
    }
    
    public function Login(){
        if($_POST){
            $User = D('User');
            //自动验证数据
            $data = $User->create();
            if(!$data){
                $this->error($User->getError());
            }
            if($query=$User->where($data)->find()){
                session('name',$query['name']);
                session('lasttime',date('Y-m-d H:i:s',$query['lasttime']));
                session('lastip',$query['lasttip']);
                session('userId',$query['id']);
                session('is_log',1);
                //记住登陆状态
                if(I('post.remember','')){
                    $exp = 7*24*3600;
                    cookie('name',$query['name'],$exp);
                    cookie('userId',$query['id'],$exp);
                    cookie('is_log',1,$exp);
                }else{
                    cookie(null);
                }
                //启动事务
                //更新登陆数据
                $data = array();
                $data['id'] = $query['id'];
                $User->create($data);
                //提交事务   $User->commit();
                $this->success('登陆成功',U(C('DEFAULT_MODULE').'/'.C('DEFAULT_ACTION')));
            }else{
                // echo $User->getLastSql();die;
                $this->error('账号或密码错误');
            }
        }else{
            $this->display('Public/login');
        }
    }
    /**
     * @example 检查登陆
     * @return boolean
     */
    public function checkLogin(){
        
        $userId = session('userId');
        $is_log = session('is_log');
        if(empty($userId)){
            $userId = cookie('userId');
            session('userId',$userId);
        }
        if(empty($is_log)){
            $is_log = cookie('is_log');
            session('is_log',$is_log);
        }
        if(!empty($userId) && $is_log == 1){
            
            return true;
        }else{
            $this->error('请先登陆','/');
        }
    }
    /**
     * @example 退出
     */
    public function Logout(){
        session(null);
        cookie('is_log',null);
        cookie('userId',null);
        cookie('name',null);
        $this->success('退出成功','/');
    }
    
    /**
     * @example 公共头部显示
     */
    public function showHeader(){
        $web['id'] = I('param.webid');
        $Web = M('website');
        $web = $Web->getById($web['id']);
        $ap = M('web_ap')->join(array('rou_website ON rou_website.id=rou_web_ap.webid'))->where(array('rou_website.id'=>$web['id']))->field('rou_web_ap.gw_id')->find();
        $this->assign('ap',$ap);
        $leftNav = file_get_contents(WEB_ROOT.'/MediaTpl/'.$web['tpl_style'].'/c_conf/config.txt');

        $leftNav = explode(';',trim($leftNav));
        $this->assign('leftNav',$leftNav);
        $this->assign('Nav','Nav');
        $this->assign('Ads','Ads');
        $this->assign('Img','Iamges');
        $this->assign('Music','Music');
        $this->assign('Vadio','Vadio');
        $this->assign('Apk','Apk');
        $this->assign('Product','Product');
        $this->assign('Book','Book');
        $this->assign('Shop','Shop');
        $this->assign('webHeader',$web);
        $this->display('Public/header');
    }
    
    Public function showFooter(){
        $this->display('Public/footer');
    }
    
    public function showDetailHeader(){
        $this->display('Public/header_detail');
    }
    public function showDetailFooter(){
        $this->display('Public/footer_detail');
    }
    
    public function alert($str){
    
        echo '<script>alert("'.$str.'")</script>';
    }
    
    /**
     *@example 更新自媒体站点index.html文件
     *@param $id 网站的id
     */
    public function setIndexHtml($wbeid){
        $Web = M('website');
        $web = $Web->find($webid);
        $hd = fopen(WEB_ROOT.$web['filename'].'/index.html','w');
        $content = file_get_contents('http://'.$_SERVER['HTTP_HOST'].$web['filename'].'/index.php?webid='.$webid);
        fwrite($hd,$content);
        fclose($hd);
         
    }
    
    /**
     * 404
     */
    Public function show404(){
        header('HTTP/1.0 404 Not Found');
        
        $this->showHeader();
        $this->display('Public/404');
        $this->showFooter();
        
    }
    
    public function _empty(){
        $this->show404();
    }
}
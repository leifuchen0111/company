<?php 
namespace We\Controller;
use Think\Controller;
class NavController extends Controller{
    public function __construct(){
        parent::__construct();
        $Public = new PublicController();
        $Public -> checkLogin();
    }
    
    
    /**
     * 导航列表
     */
    public function navList(){
        $Public = new PublicController();
        $data['webid'] = I('get.webid','');
        $Nav = M('webnav');
        $nav = $Nav->where($data)->order('\'order\' desc')->select();
        $this->assign('nav',$nav);
        $Public->showHeader();
        $this->display('navList');
        $Public->showFooter();
    }
    
    /**
     * 添加导航
     */
    public function navAdd(){
        $Public = new PublicController();
        
        if(IS_POST){
            $Nav = M('webnav');
            $data = $Nav->create();
            $query =  $Nav->add();

            //提示wifidog更新导航信息
//check website ID
        
    $api = array();
            $where = array();
            //更新静态首页zip
            $Web = M('website');
            $web = $Web->find($data['webid']);
            $webid = $data['webid'];
            $Web_Ap = M('web_ap');
            $query = $Web_Ap->where(array('webid'=>$webid))->field('id')->select();
            $WebApi = M('webapi');
            foreach($query as $item){
            	 $where['api'] = 'getNav';
                        $where['webid'] = $item['id'];
                        $api['state'] = '1';
                        $WebApi->where($where)->data($api)->save();
            }           

            $hd = fopen(WEB_ROOT.$web['filename'].'/index.html','w');
            $content = file_get_contents('http://'.$_SERVER['HTTP_HOST'].$web['filename'].'/index.php?webid='.$webid);
            fwrite($hd,$content);
            fclose($hd);
            
            
            
            
            if($query){
                $this->success('添加成功','navList?webid='.$_POST['webid']);
            
            }else{
                
                $this->error('添加失败');
            }
            
        }else{
            
            $Public->showHeader();
            $this->display('Nav/navAdd');
            $Public->showFooter();
        }
    }
    
    /**
     * 导航编辑
     */
    
    public function navEdit(){
        $Public = new PublicController();
        $Nav = M('webnav');
        if(IS_POST){
            $data['id'] = I('post.id','');
            $data['navname'] = I('post.navname','');
            $data['url'] = I('post.url','');
            $data['order'] = I('post.order','');
            $query = $Nav->data($data)->save();
            $web = $Nav->getById($data['id']);
            //提示wifidog更新导航信息
            $api = array();
            $where = array();
            
            $Web_Ap = M('web_ap');
            $query = $Web_Ap->where(array('webid'=>$web['webid']))->field('id')->select();
            $WebApi = M('webapi');
            foreach($query as $item){
                     $where['api'] = 'getNav';
                        $where['webid'] = $item['id'];
                        $api['state'] = '1';
                        $WebApi->where($where)->data($api)->save();
            }
            $where['api'] = 'getNav';
            //更新首页静态文件
            $Web = M('website');
            $web = $Web->find($web['webid']);
            $webid = $web['webid'];
            $hd = fopen(WEB_ROOT.$web['filename'].'/index.html','w');
            $content = file_get_contents('http://'.$_SERVER['HTTP_HOST'].$web['filename'].'/index.php?webid='.$webid);
            fwrite($hd,$content);
            fclose($hd);
            
            
            if($query){
                $this->success('编辑成功','navList?webid='.I('post.webid',''));
            }else{
                $this->error('编辑失败');
            }
        
        }else{
            
            $data['id'] = I('get.id');
            $nav = $Nav->where($data)->find();
            if(empty($nav)) $Public->error('资源不存在');
            $this->assign('nav',$nav);
            $html['mode'] = 'edit';
            $this->assign('html',$html);
            $Public->showHeader();
            $this->display('navEdit');
            $Public->showFooter();
        }
    }
    
    /**
     * 导航删除
     */
    public function navDel(){
        if(IS_AJAX){
            $Nav = M('webnav');
            $data = array(); 
            $data['id'] = array('in',I('get.id',''));
            //提示wifidog更新导航信息
            
            $web = $Nav->getById($data['id']);
            $api = array();
            $where = array();
            
            $Web_Ap = M('web_ap');
            $query = $Web_Ap->where(array('webid'=>$web['webid']))->field('id')->select();
            $WebApi = M('webapi');
            foreach($query as $item){
                     $where['api'] = 'getNav';
                        $where['webid'] = $item['id'];
                        $api['state'] = '1';
                        $WebApi->where($where)->data($api)->save();
            }
            $query = $Nav->where($data)->delete();
            
            //更新首页静态文件
            $Web = M('website');
            $web = $Web->find($web['webid']);
            $webid = $web['webid'];
            $hd = fopen(WEB_ROOT.$web['filename'].'/index.html','w');
            $content = file_get_contents('http://'.$_SERVER['HTTP_HOST'].$web['filename'].'/index.php?webid='.$webid);
            fwrite($hd,$content);
            fclose($hd);
            
            if($query){
                echo json_encode(array('state'=>0,'msg'=>'删除成功'));exit;
            }else{
                echo json_encode(array('state'=>1,'msg'=>'删除失败'));exit;
            }
           
        
        }
    }
}
?>

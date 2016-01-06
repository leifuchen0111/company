<?php
namespace We\Controller;
use Think\Controller; 
class NewsController extends Controller{
    private $Public;
    private $News;
    private $Web;
    private $Cate;
    private $Web_Ap;
    private $WebApi;
    public function __construct(){
        
        parent::__construct();
        $this->Public = new PublicController();
        $this->Public->checkLogin();
        $this->News = M('news');
        $this->Web = M('website');
        $this->Cate = M('category');
        $this->Web_Ap = M('web_ap');
        $this->WebApi = M('webapi');
    }
    
    /**
     * @新闻列表
     */
    public function newsList(){
        
       $news = $this->News->field('rou_category.cat_name,rou_news.*')->join(array('rou_category ON rou_category.id=rou_news.cat_id'))->where(array('rou_category.webid'=>I('get.webid'),'type'=>'news'))->select();
       //echo $this->News->getLastSql();die;
       // var_dump($news);
       $this->assign('news',$news);
       $this->Public->showHeader();
       $this->display('NewsList');
       $this->Public->showFooter();
        
    }
    /**
     * @example 添加新闻
     */
    public function newAdd(){
        
        if(IS_POST){
           //dump($_POST);dump($_FILES);die;
            $web = M('website')->getById(I('post.id'));
            
            $data = array();
            $data['ishot'] = I('post.ishot','');
            $data['title'] = I('post.title','');
            $data['content'] = str_replace('"', '', $_POST['content']);
            $data['order'] = I('post.order','');
            $data['cat_id'] = I('post.cat_id','');
            
            $insert = $this->News->data($data)->add();
            if(!$insert) $this->error('添加失败');
            
            $data['cate_id'] = $this->News->getLastInsID();
            $data['type'] = 'new_cover';           
            if($_FILES['img']['error'] !=4 ){
            
                $name = uniqid();
                if($_FILES['cover_img']['size']>2*1024*1024) $this->error('图片不得大于2M');
                if(!in_array($_FILES['img']['type'],array('image/jpeg','image/gif','image/png'))){
                    $this->error('图片格式错误');
                }
            
                if(!is_dir(WEB_ROOT.$web['filename'].'/resource')) mkdir(WEB_ROOT.$web['filename'].'/resource',0777,true);
                move_uploaded_file($_FILES['img']['tmp_name'],WEB_ROOT.$web['filename'].'/resource'.'/'.$name.'.jpg') or die('文件上传失败');

                $data['url'] = $web['filename'].'/resource'.'/'.$name.'.jpg';
                M('images')->data($data)->add();
            
            }
           //更新api<--
            
            $web_ap = $this->Web_Ap->field('id')->where(array('webid'=>I('post.id','')))->select();
            foreach($web_ap as $v){
                $webapi = $this->WebApi->field('id,influ_ids')->where(array('webid'=>$v['id'],'api'=>'getNews'))->find();
                $data = array();
                $data['id'] = $webapi['id'];
                $data['state'] = '1';
                $data['influ_ids'] = $webapi['influ_ids']?$webapi['influ_ids'].','.$insert:$insert;
                
                $data['influ_ids'] = implode(',', array_unique(explode(',', $data['influ_ids'])));
                
                $query = $this->WebApi->data($data)->save();

                if(!$query) $this->error('推送失败');
            }
            //-->
            $this->success('添加成功','newsList?webid='.I('post.id',''));
            
        }else{
           
            $cate = $this->Cate->where(array('webid'=>I('get.webid',''),'type'=>'news'))->select();
            
            $this->assign('cate',$cate);
            
            $this->Public->showHeader();
            $this->display('NewAdd');
            $this->Public->showFooter();
            
        }
    }
    
    /**
     * @example 删除新闻
     */
    
    public function newDel(){
        
        if(IS_AJAX){
            if(!I('get.id','')){
                echo json_encode(array('state'=>1,'msg'=>'参数错误'));
            }
            $data['rou_news.id'] = array('in',I('get.id',''));

            
            
            $web = $this->News->where($data)->field('rou_category.webid')->join('rou_category ON rou_category.id=rou_news.cat_id')->select();
            
            $web = $this->Web->find($web[0]['webid']);
             
            $del = $this->News->where(array('id'=>array('in',I('get.id',''))))->delete();
            if(!$del){
                echo json_encode(array('state'=>1,'msg'=>'删除失败'));exit;
            }
        
            if(!file_exists(WEB_ROOT.$web['filename'].'/islua.flag')){
        
                //属于静态页面类型，更新首页，重新下载模板包
                $this->WebApi->data(array('state'=>'1'))->where(array('webid'=>$web['id'],'api'=>'downTpl'));
                //更新首页静态文件
                 
                $hd = fopen(WEB_ROOT.$web['filename'].'/index.html','w');
                $content = file_get_contents('http://'.$_SERVER['HTTP_HOST'].$web['filename'].'/index.php?webid='.$web['id']);
                fwrite($hd,$content);
                fclose($hd);
            }else{
        
                //属于动态页面，记录更改的ID
                $query = $this->Web_Ap->where(array('webid'=>$web['id']))->field('id')->find();
                 
                $old = $this->WebApi->field('id,influ_ids')->where(array('webid'=>$query['id'],'api'=>'delNews'))->find();
                //   var_dump($old);
                $old_id = $old['influ_ids'];
                $new_id = $old_id?$old_id.','.I('get.id',''):I('get.id','');
                //去除重复
                 
                $id_arr = explode(',', $new_id);
                $id_arr = array_unique($id_arr);
                $new_id = implode(',',$id_arr);
        
                 
                $upd['state'] = '1';
                $upd['id'] = $old['id'];
                $upd['influ_ids'] = $new_id;
                $this->WebApi->data($upd)->save();
                // echo $WebApi->getLastSql();
            }
             
            echo json_encode(array('state'=>0,'msg'=>'删除成功'));

        }
    }
    /**
     * @新闻抓取
     */
    public function newsGrab(){
        
        import('ORG.Util.Simple_html_dom');
        include('simple_html_dom.php');
        ignore_user_abort(true);
        set_time_limit(0);
        $url = 'http://ent.sina.com.cn/';
        $str= file_get_contents($url);
        
        $html= new simple_html_dom();
        //var_dump($dom);
        $html->load($str);
        
        $ulist = $html->find("a[target='_blank']");
        
        $arr = array();
        
        foreach($ulist as $e){
            if(preg_match('/^http:\/\/ent\.sina\.com\.cn\/[0-9a-z\/\-]*\.shtml$/',$e->href)){
        
                array_push($arr,$e->href);
        
            }
        
        
        }
        $arr = array_unique($arr);
        rsort($arr);
        $count = count($arr);
      //  echo $count;
    //   var_dump($arr);die;
        $arti = array();
        
        for($i=0;$i<$count;$i++){
        
        
            $url = $arr[$i];
            $str = file_get_contents($url);
       //     if(!$str) continue;
            $html = new simple_html_dom();
            //var_dump($dom);
            $html->load($str);
        
            $title = $html->find('#artibodyTitle');
            
            $content = $html->find('#artibody');
            
        
            foreach($title as $e){
        
                $arti[$i]['title'] = $e->text();
        
            }
        
            foreach($content as $e){
        
                $arti[$i]['content'] = $e->text();
        
            }
            
            
        
        }
        
        $order = 1;
      //  var_dump($arti);die;
       
        foreach($arti as $v){
        
            $data = array();
            $data['cat_id'] = 16;
            $data['title'] = $v['title'];
            $data['content'] = $v['content'];
            if(!$data['title'] || !$data['content']) continue;
            $data['posttime'] = time();
            $data['order'] = $order;
            $order++;
            $this->News->data($data)->add();
        }
    
    }
    
    public function _empty(){
        
        $this->Public = new PublicController();
        $this->Public->show404();
    }
    
}
?>
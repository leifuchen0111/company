<?php 
namespace We\Controller;
use Think\Controller;
class ApkController extends Controller{
    private $Apk;
    private $Public;
    private $Web;
    private $Cate;
    private $Web_Ap;
    private $WebApi;
    public function __construct(){
        parent::__construct();
        $this->Public = new PublicController();
        $this->Public->checkLogin();
        $this->Apk = M('apk');
        $this->Web = M('website');
        $this->Cate = M('category');       
        $this->Web_Ap = M('web_ap');
        $this->WebApi = M('webapi'); 
    }
    
    /**
     * apk列表
     */
    public function apkList(){
        
        $apk = $this->Apk->field('rou_category.`cat_name`,rou_apk.downcount,rou_apk.name,rou_apk.desc,rou_apk.id')->where(array('rou_category.webid'=>I('get.webid',''),'rou_category.type'=>array('in','app,game')))->join(array('`rou_category` on rou_category.`id`=rou_apk.`cat_id`'))->select();
//echo $this->Apk->getLastSql();die;
        $this->assign('apk',$apk);
    //    var_dump($apk);die;
        $this->Public->showHeader();
        $this->display('ApkList');
        $this->Public->showFooter();
    }
    protected function getFilePath($path,$filename){
        $path = I('param.'.$path);
        $pathArr = explode(',',$path);
        $filename = I('param.'.$filename);
        $count = count($pathArr);
        if($count <= 1){
            return $path.$filename;
        }else{
            $filenameArr = explode(',',$filename);
            $return = array();
            for($i=0;$i<$count;$i++){
                $return[] = $pathArr[$i].$filenameArr[$i];
            }
            return $return;
        }

    }
    /**
     * @example Apk 添加
     */
    public function ApkAdd(){
        
        if(IS_POST){
            ini_set('upload_max_filesize','100M');
            $Apk = D('apk');
            $Apk->create();
            $webid = $Apk->webid;

            $config = array(
                'exts' => 'apk',
                'rootPath' => './',
                'subName' => array(),
                'savePath' => I('post.path','')
            );

            $Upload = new \Think\Upload($config);
            $info = $Upload->uploadOne($_FILES['apk']);
            if($Upload->getError()){
                $this->error($Upload->getError());
            }

            $Apk->img = $this->getFilePath('path','filename');
            $Apk->url = $info['savepath'].'/'.$info['savename'];
            if(!$Apk->add()){
                $this->error('Apk上传失败');
            }

            $insID = $Apk->getLastInsId();
            $images = $this->getFilePath('cpath','cfilename') ;
            $this->insertImages($images,$insID);

            $this->updateApi($webid,'getApk',$insID);

            $this->success('添加成功');

        }else{
            
            ini_set('upload_max_filesize','100M');
            $html['mode'] = 'add';
            $webid = I('get.webid');
            $Website = M('website');

            $cate = $this->Cate->where(array('webid'=>I('get.webid',''),'type'=>array('in','app,game')))->select();
            $web = $Website->getById($webid);
            $filepath = urlencode(str_replace('/','.',$web['filename'].'/reource'));

            $this->assign('filepath',$filepath);
            $this->assign('cate',$cate);
            $this->assign('html',$html);
            $this->Public->showHeader();
            $this->display('ApkEdit');
            $this->Public->showFooter();
        }
    }

    protected function insertImages($images,$insID)
    {
        if($images) {
            //写入多图片路径
            $Img = M('images');
            $data['type'] = 'apk';
            $data['desc'] = $insID;
            foreach ($images as $k => $v) {
                $data['url'] = $v;
                $Img->add($data);
            }
        }
        return true;
    }
    
    /**
     * @example APK删除
     */
     
    public function delApk(){
       if(IS_AJAX){
        $data['id'] = array('in',I('get.id',''));
        $Pro = M('apk');
        $pro = $Pro->where($data)->field('webid,id')->select();
        $img_webid = array();
        foreach($pro as $item){
            $img_webid[] = $item['id'];
        }
        foreach($pro as $item){
            unlink(WEB_ROOT.$item['url']);
            unlink(WEB_ROOT.$item['img']);
        }
         if(!$Pro->where($data)->delete()){
            echo json_encode(array('state'=>1,'msg'=>'删除失败'));exit;
         } 
        $web = M('website')->find($pro[0]['webid']);
      //  var_dump($web);
        if(file_exists(WEB_ROOT.$web['filename'].'/islua.flag')){
            //更新api信息
            $Api = M('webapi');
            $arr['state']  = '1';
            $arr['influ_ids'] = I('get.id','');
            $where['api'] = 'delApk';
            $api_webid = M('web_ap')->field('id')->where(array('webid'=>$pro[0]['webid']))->select();
             
            foreach($api_webid as $v){
                $where['webid'] = $v['id'];
                $oldids = $Api->where($where)->field('influ_ids')->find();
                
                if($oldids['influ_ids'])  $arr['influ_ids'].=','.$oldids['influ_ids'];
                
                $arr['influ_ids'] = implode(',', array_unique(explode(',', $arr['influ_ids'])));
                 
                $Api->where($where)->data($arr)->save();

            }
        }else{
             
             
            //更新首页静态文件
            $Web = M('website');
            $web = $Web->find($pro[0]['web_id']);
            $webid = $web['id'];
            $hd = fopen(WEB_ROOT.$web['filename'].'/index.html','w');
            $content = file_get_contents('http://'.$_SERVER['HTTP_HOST'].$web['filename'].'/index.php?webid='.$webid);
            fwrite($hd,$content);
            fclose($hd);
            //删除商品详情页文件
            $file_id = explode(',', I('get.id',''));
            $lenght = count($file_id);
            for($i=0;$i<$lenght;$i++){
                unlink(WEB_ROOT.$web['filename'].'/webid_'.$webid.'pro_id_'.$file_id[$i].'.html');
            }
        }
        //删除商品相关图片数据
         
        echo json_encode(array('state'=>0,'msg'=>'删除成功'));exit;
    
      }
        
    }

    protected function updateApi($webid,$api,$id)
    {

        $Api = D('webapi');
        $webap = M('web_ap')->getFieldByWebid($webid,'id');

        $map['api'] = $api;
        $map['webid'] = $webap;

        $data = $Api->where($map)->find();
        if(empty($data)){
            $Api->create($map);
            $apiid = $Api->add();
            $data = $map;
            $data['id'] = $apiid;
        }
        $Api->create($data);

        $influ_ids = empty($Api->influ_ids)?$id:$Api->influ_ids.','.$id;
        $Api->influ_ids = implode(',',array_unique(explode(',',$influ_ids)));
        $Api->state = '1';
        return $Api->save()?true:false;
    }
    /**
     * 404
     */
    public function _empty(){

        $this->Public = new PublicController();
        $this->Public->show404();
        
    }
}
?>
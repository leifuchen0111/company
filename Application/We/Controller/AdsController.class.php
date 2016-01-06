<?php 
namespace We\Controller;
use Think\Controller;
class AdsController extends Controller{
    public function __construct(){
        parent::__construct();
        $Public = new PublicController();
        $Public->checkLogin();
    }
   /**
    * @example 广告列表
    */
   public function adsList(){
       $Public = new PublicController();
       $Img = M('ads');
    //   $data['type'] = 'slider';
       $data['webid'] = I('get.webid','');
       $images = $Img->where($data)->select();
      
       $this->assign('img',$images);
       $Public->showHeader();
       $this->display('Ads/adsList');
       $Public->showFooter();
   }
   /**
    * @example 广告添加
    */
   public function adsAdd(){

       $Public = new PublicController();
       if(IS_POST){
           $Ads = D('Ads');
           $data = $Ads->create();
           $img = $this->getFilePath();
           if(!$img)
           {
               $this->error('图片上传失败，请重新上传');
           }
            $Ads->img = $img;
           if(!$Ads->add())
           {

               $this->error('广告添加失败');
           }
           $query = $this->updateApi($data['webid'],'getAds',$Ads->getLastInsId());
           $query?$this->success('添加成功'):$this->error('添加失败');

       }else{
           $webid = I('get.webid');
           $Website = M('website');

           $web = $Website->getById($webid);
           if(!is_dir($web['filename'].'/reource')) {
               mkdir($web['filename'].'/reource');
           }
           $filepath = urlencode(str_replace('/','.',$web['filename'].'/reource'));

           $this->assign('filepath',$filepath);
           $Public->showHeader();
           $this->display('Ads/adsAdd');
           $Public->showFooter();
       }
   }
   /**
    * 广告删除
    */
   public function adsDel(){
       if(IS_AJAX){
           $Ads = M('images');
           $id = I('get.id','');
           if(!$id){
               echo json_encode(array('state'=>1,'msg'=>'参数错误'));
           }
           $data['id'] = array('in',$id);
           $Images = M('ads');

           $web = $Images->where($data)->field('webid,url')->select();

           $web = M('website')->find($web[0]['webid']);

           $del = M('ads')->where(array('id'=>array('in',I('get.id',''))))->delete();
           if(!$del){
               echo json_encode(array('state'=>1,'msg'=>'删除失败'));exit;
           }
           //删除广告图片
           foreach($web as $item){
               unlink(WEB_ROOT.$item['url']);
           }
           $this->updateApi($web['id'],'delAds',$id);
           echo json_encode(array('state'=>0,'msg'=>'删除成功'));
       }
   }
    protected function getFilePath(){
        $path = I('param.path');
        $filename = I('param.filename');
        if(!empty($path) && !empty($filename)){
            return $path.$filename;
        }

    }

    protected function updateApi($webid,$api,$id)
    {

        $Api = D('webapi');
        $Webap = M('web_ap');
        $map = array();
        $map['webid'] = $webid;
        $web_ap = $Webap->where($map)->field('id')->select();

        foreach($web_ap as $item){
            $webap = $item['id'];

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
            $result = $Api->save();

        }

        return $result?true:false;
    }
   public function _empty(){
       $Public = new PublicController();
       $Public->show404();
       
   }
    
}
?>

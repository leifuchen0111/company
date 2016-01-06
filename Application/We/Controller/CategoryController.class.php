<?php 
namespace We\Controller;
use Think\Controller;
use Think\Upload;

class CategoryController extends Controller{
    private $Cate;
    private $Public;
    private $Website;
    public function __construct(){
        parent::__construct();
        $this->Public = new PublicController();
        
        $this->Public->checkLogin();
        $this->Cate = M('category');
        $this->Website = D('website');
    }

    /**
    * @example 分类catList列表
    */
   public function catList(){
       $this->Public = new PublicController();
 
       $data['webid'] = I('get.webid','');
       $data['type'] = I('get.type','');
       if($data['type'] == 'app') $data['type'] = array('in','app,game');
       $cats = $this->Cate->where($data)->select();

       $data['type'] = I('get.type','');
       $this->assign('data',$data);
       $this->assign('cats',$cats);
       $this->Public->showHeader();
       $this->display('Cat/catList');
       $this->Public->showFooter();
   }
   /**
    * @example 分类
    */
   public function catSave(){
       $this->Public = new PublicController();
       if(IS_POST){
           $Cat = D('category');
           if(!$Cat->create()){
               $this->error($Cat->getError());
           };
           if($_FILES['cover_img']){
               $web = M('website')->find($Cat->webid);
               $config = array(
                   'exts' => 'jpg,png',
                   'rootPath' => './',
                   'subName' => array(),
                   'savePath' => $web['filename'].'/resource/'
               );
               $Upload = new \Think\Upload($config);
               $info = $Upload->uploadOne($_FILES['cover_img']);

               if($Upload->getError()){
                   $this->error($Upload->getError());
               }
               $Cat->url = $info['savepath'].$info['savename'];
               $id = $Cat->cid;
               if(empty($id)){
                   if($Cat->add()){
                       $this->updApi($web['id'],'getCat',$Cat->getLastInsId());


                       $this->success('添加成功');
                   }else{
                       $this->error('添加失败');
                   }
               }else{
                   if($Cat->save()){

                       $this->updApi($web['id'],'editCat',$id);

                       $this->success('修改成功');
                   }else{
                       $Cat->error('修改失败');
                   }
               }
           }

       }
   }
    public function catAdd(){

        $data['webid'] = I('get.webid','');
        $type = I('get.type','');
        $data['type'] = $type;
        if($data['type'] == 'app') $data['type'] = array('in','app,game');
        $cats = $this->Cate->where($data)->select();

        $this->assign('cats',$cats);
        $this->assign('type',$type);
        $this->Public->showHeader();
        $this->display('Cat/catAdd');
        $this->Public->showFooter();

    }

    public function CatEdit(){
        $id = I('get.id','');
        $Cat = M('category');
        $cate = $Cat->find($id);

        $data['webid'] = I('get.webid','');
        $data['type'] = $cate['type'];

        if($data['type'] == 'app') $data['type'] = array('in','app,game');
        $cats = $this->Cate->where($data)->select();
        $this->assign('cats',$cats);
        $this->assign('type',$cate['type']);

        $this->assign('cate',$cate);
        R('Public/showHeader');
        $this->display('Cat/catAdd');
        R('Public/showFooter');

    }

   /**
    * 广告删除
    */
   public function delCat(){
       $id = I('get.id','');
       $webid = M('category')->getFieldById($id,'webid');
       M('category')->where(array('id'=>array('in',$id)))->delete();
       M('product')->where(array('cat_id'=>array('in',$id)))->delete();
       $this->updApi($webid,'delCat',$id);
       $this->ajaxReturn(array('state'=>0,'msg'=>'删除成功'));
   }
    protected function updApi($webid,$api,$id)
    {
        //更新api信息
        $Api = M('webapi');
        $arr['state'] = '1';
        $arr['influ_ids'] = $id;
        $where['api'] = $api;
        $api_webid = M('web_ap')->field('id')->where(array('webid' => $webid))->select();
        foreach ($api_webid as $v) {
            $where['webid'] = $v['id'];
            $oldids = $Api->where($where)->field('influ_ids')->find();
            if (!$oldids) {
                $where['order'] = '10';
                $Api->add($where);
            }
            if ($oldids['influ_ids']) $arr['influ_ids'] .= ',' . $oldids['influ_ids'];
            $arr['influ_ids'] = implode(',', array_unique(explode(',', $arr['influ_ids'])));
            $Api->where($where)->data($arr)->save();


        }
    }
   public function _empty(){
       $this->Public = new PublicController();
       $this->Public->show404();
       
   }
    
}
?>
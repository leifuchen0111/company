<?php 
namespace Catering\Controller;
class CateProController extends BaseController{

    public function __construct()
    {
        parent::__construct();

    }

   public function cate(){

       $Cate = M('category');
       $webid = I('get.webid');
       $type = I('get.type','');

       $map = array();
       $map['webid'] = $webid;
       $map['type'] = $type;
       $cates = $Cate->where($map)->select();

       $this->cates = $cates;
       $this->display();

   }


   public function save()
   {

       $Cate = D('category');
       if(!$data = $Cate->create()){

           $this->error($Cate->getError());
       }
       if($_FILES) {
           $upload = true;
           $config = array(
               'exts' => 'jpg,png',
               'rootPath' => './',
               'savePath' => $_SESSION['web']['filename'] . '/resource/'
           );
           $Upload = new \Think\Upload($config);
           $info = $Upload->uploadOne($_FILES['cover_img']);
       }

       if($Cate->id){   //修改

           if($info){

               $Cate->image = $info['savepath'].$info['savename'];
           }

           if($Cate->save()){

               updateApi($data['webid'],'getAds',$Cate->id);
               $this->success('修改成功');
           }else{

               $this->error('修改失败');
           }

       }else{   //添加

            if($upload){
                if(!$info){
                    $this->error($Upload->getError());
                }
                $Cate->image = $info['savepath'].$info['savename'];
            }

           if($Cate->add()){

               updateApi($data['webid'],'getAds',$Cate->getLastInsId());
               $this->success('添加成功');
           }else{
               $this->error('添加失败');
           }

       }
   }

   public function edit()
   {
       $Cate = M('category');
       $id = I('get.id',0);
       $webid = I('get.webid',0);

       $cate = $Cate->find($id);

       $map = array(
           'webid' => $webid
       );
       $cates = $Cate->where($map)->select();

       $this->type = $cate['type'];
       $this->cates = $cates;
       $this->cate = $cate;
       $this->display('add');
   }

    public function add()
    {
        $Cate = M('category');

        $map = array(
            'webid' => I('get.webid',0)
        );
        $list = $Cate->where($map)->select();

        $this->list = $list;
        $this->display();

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
    
}
?>
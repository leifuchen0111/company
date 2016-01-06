<?php 
namespace We\Controller;
use Think\Controller;
class ProductController extends Controller{
    private $Cate;
    private $Product;
    public function __construct(){
        parent::__construct();
        $Public = new PublicController();
        $Public->checkLogin();
        $this->Cate = M('category');
        $this->Product = M('product');
        $this->ProImg = M('pro_images');
    }
    
    //商品列表
   public function proList(){
       $Public = new PublicController();
       $Pro = M('product');
       
       $data['webid'] = I('get.webid','');
       $products = $Pro->where($data)->select();
      
       $this->assign('product',$products);
       $Public->showHeader();
       $this->display('Product/proList');
       $Public->showFooter();
   }
    protected function getFilePath(){
        $path = I('param.path');
        $filename = I('param.filename');
        if(!empty($path) && !empty($filename)){
            return $path.$filename;
        }

    }
   //商品添加
   public function proAdd(){
       $Pro = M('product');
       $Public = new PublicController();
       if(IS_POST){
           $Website = M('website');

           $insert = $Pro->create();
           
           $webid = $insert['webid'];
           $web = $Website->getById(I('post.webid',''));
           if($mainImg = $this->getFilePath())
           {
               $Pro->main_img = $mainImg;
           }
           $query = $Pro->add();

           //更新wifidog接口信息
           $Api = M('webapi');
           $data = array();
           $data['state'] = '1';
           $web_ap = M('web_ap')->field('id')->where(array('webid'=>$webid))->select();
           $arr = array();
           foreach($web_ap as $v){
               $arr[] = $v['id'];
           }
           // var_dump($web_ap);
           $where = array('api'=>'getProducts','webid'=>array('in',implode(',', $arr)));
           
           $Api->where($where)->data(array('state'=>'1'))->save();
           
               //生成静态页面
    		 if(file_exists(WEB_ROOT.$web['filename'].'/cateList.php')){
                   $hd = fopen(WEB_ROOT.$web['filename'].'/cat_'.$insert['cat_id'].'.html','w');
                   $content = file_get_contents('http://'.$_SERVER['HTTP_HOST'].$web['filename'].'/cateList.php?webid='.$webid.'&cat_id='.$insert['cat_id']);
                   fwrite($hd,$content);
                   fclose($hd);
               }
               if(file_exists(WEB_ROOT.$web['filename'].'/detail.php')){
                   $hd = fopen(WEB_ROOT.$web['filename'].'/pro_'.$query.'.html','w');
                   $content = file_get_contents('http://'.$_SERVER['HTTP_HOST'].$web['filename'].'/detail.php?webid='.$webid.'&pro_id='.$query);
                   fwrite($hd,$content);
                   fclose($hd);
               }
               
               $hd = fopen(WEB_ROOT.$web['filename'].'/index.html','w');
               $content = file_get_contents('http://'.$_SERVER['HTTP_HOST'].$web['filename'].'/index.php?webid='.$webid);
               fwrite($hd,$content);
               fclose($hd);
               
               
              if(file_exists(WEB_ROOT.$web['filename'].'/islua.flag')){
                   
                   /*$data = array();
                   $web_ap = M('web_ap')->field('id')->where(array('webid'=>$webid))->select();
                    $arr = array();
                    foreach($web_ap as $v){
                        $arr[] = $v['id'];
                    }
                  // var_dump($web_ap);
                   $where = array('api'=>'getProducts','webid'=>array('in',implode(',', $arr)));
                   $oldid = $Api->where($where)->field('influ_ids')->find();
                   $data['influ_ids'] = empty($oldid['influ_ids'])?$query:$oldid['influ_ids'].','.$query;
                   $data['influ_ids'] = implode(',', array_unique(explode(',', $data['influ_ids'])));
                   $Api->where($where)->data($data)->save();*/

                  $this->updApi($webid,'getProducts',$query);
              }
             //  echo $Api->getLastSql();die;
         
           
         //  echo $Api->getLastSql();die;
           $query?$this->success('添加成功',U('Product/proList').'?webid='.I('post.webid','')):$this->error('添加失败');
       }else{

           $webid = I('get.webid');
           $Website = M('website');
           $web = $Website->getById($webid);
           //获取商品添加模板
           $filepath = urlencode(str_replace('/','.',$web['filename'].'/reource'));
           $this->assign('filepath',$filepath);
           $cates = $this->Cate->where(array('webid'=>I('get.webid',''),'type'=>'product'))->select();
           $this->assign('cates',$cates);
           $Public->showHeader();
           $this->display('Product/proAdd');
           $Public->showFooter();
       }
   }
   /**
    * @example 商品删除
    */
   public function delPro(){
       
           $data['id'] = array('in',I('get.id',''));
           $Pro = M('product');
           $pro = $Pro->where($data)->field('webid,id')->select();
           
           $img_webid = array();
           foreach($pro as $item){
               $img_webid[] = $item['id'];
           }
           
           //删除商品相关图片文件
           $Img = M('pro_images');
           $img_file = $Img->where(array('pro_id'=>array('in',implode(',',$img_webid))))->field('url')->select();
           
           foreach($img_file as $item){
               unlink(WEB_ROOT.$item['url']);
           }
           
           if(!$Pro->where($data)->delete()){
               echo json_encode(array('state'=>1,'msg'=>'删除失败'));exit;
           }
           
           
           
           $web = M('website')->find($pro[0]['webid']);
          
           if(file_exists(WEB_ROOT.$web['filename'].'/islua.flag')){
           //更新api信息

               $Api = M('webapi');
               $arr['state']  = '1';
               $arr['influ_ids'] = I('get.id','');
               $where['api'] = 'delProducts';
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
               $web = $Web->find($pro[0]['webid']);
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

    /**
     * 商品编辑
     */
    public function editPro()
    {
        if(IS_POST) {
            $Product = D('Product');
            $webid = I('post.webid');
            $Product ->create();
            $id = $Product->id;
            if($mainImg = $this->getFilePath())
            {
                $Product->main_img = $mainImg;
            }
            $query = $Product->save();
            $this->updApi($webid,'editProduct',$id);

            $this->success('修改成功',U('proList',array('webid'=>$webid)));
        }
        else
        {
            $webid = I('get.webid','');
            $web = M('website')->find($webid);
            //获取商品添加模板
            $filepath = urlencode(str_replace('/','.',$web['filename'].'/reource'));
            $this->assign('filepath',$filepath);
            $cates = $this->Cate->where(array('webid'=>$webid,'type'=>'product'))->select();
            $this->assign('cates',$cates);

            $id = I('get.id');
            $pro = M('product')->find($id);
            $this->assign('pro',$pro);
            R('Public/showHeader');
            $this->display('Product/proEdit');
            R('Public/showFooter');
        }

    }
   public function _empty(){
       $Public = new PublicController();
       $Public->show404();
       
   }

    protected function updApi($webid,$api,$id){
        //更新api信息
        $Api = M('webapi');
        $arr['state']  = '1';
        $arr['influ_ids'] = $id;
        $where['api'] = $api;
        $api_webid = M('web_ap')->field('id')->where(array('webid'=>$webid))->select();
        foreach($api_webid as $v){
            $where['webid'] = $v['id'];
            $oldids = $Api->where($where)->field('influ_ids')->find();


            if(!$oldids){
                $where['order'] = '10';
                $Api->add($where);

            }
            if($oldids['influ_ids'])  $arr['influ_ids'].=','.$oldids['influ_ids'];
            $arr['influ_ids'] = implode(',', array_unique(explode(',', $arr['influ_ids'])));
            $Api->where($where)->data($arr)->save();


        }
    }
    
}
?>

<?php 
namespace We\Controller;
use Think\Controller;
class OrderController extends Controller{
    private $Order;
    private $Public;
    private $Order_Pro;
    private $Product;
    public function __construct(){
        parent::__construct();
        $this->Public = new PublicController();
        
        $this->Public->checkLogin();
        $this->Cate = M('category');
        $this->Website = D('website');
        $this->Product = M('product');
        $this->Order = M('order');
        $this->Order_Pro = M('order_pro');
    }

    /**
    * @example 分类catList列表
    */
   public function addOrder(){
       $this->Public = new PublicController();
       $id = I('get.id','');
       file_put_contents('id.txt', $id);
       $products = $this->Product->where(array('id'=>array('in',$id)))->field('price,id')->select();
       $sum = '';
       foreach($products as $item){
           $sum+=$item['price'];
       }
       $data = array(
           'time'    => time(),
           'remark'  => '',
           'tableNO' => I('get.table',''),
           'sum'     => $sum,
           'webid'   => I('get.webid',''),
       );
       
       $this->Order->data($data)->add();
       $proId = explode(',',$id);
       $order_id = $this->Order->getLastInsID();
       $len = count($proId);
       for($i=0;$i<$len;$i++){
           $order_pro = array(
               'order_id' => $order_id,
               'pro_id'   => $proId[$i],
           );
           $this->Order_Pro->data($order_pro)->add();
       }
       
   }
   
   public function getOrder(){
       
       
   }
   /**
    * @example 分类
    */
   public function catAdd(){
       $this->Public = new PublicController();
       if(IS_POST){
            $this->Cate->create();
            if($this->Cate->add()){
                $web = $this->Website->getById(I('post.webid',''));
                $hd = fopen(WEB_ROOT.$web['filename'].'/category.html','w');
                $content = file_get_contents('http://'.$_SERVER['HTTP_HOST'].$web['filename'].'/category.php?webid='.$web['id']);
                fwrite($hd,$content);
                fclose($hd);
                
                $hd = fopen(WEB_ROOT.$web['filename'].'/cat_'.$this->Cate->getLastInsID().'.html','w');
                $content = file_get_contents('http://'.$_SERVER['HTTP_HOST'].$web['filename'].'/cateList.php?webid='.$web['id'].'&cat_id='.$this->Cate->getLastInsID());
                fwrite($hd,$content);
                fclose($hd);
                $this->success('添加成功');
                
                
            }else{
                
                $this->error('添加失败');
            }    
        
           
       }else{
           $this->Public->showHeader();
           $this->display('Cat/catAdd');
           $this->Public->showFooter();
       }
   }
   
   
   
   /**
    * 广告删除
    */
   public function adsDel(){
       if(IS_AJAX){
           $Ads = M('images');
           $data['id'] = array('in',I('get.id',''));
           $Images = M('images');
           $web = $Images->where($data)->field('webid,url')->select();
           //删除广告图片
           foreach($web as $item){
               unlink(WEB_ROOT.$item['url']);
           }

           //更新api信息
           $Api = M('webapi');
           $arr['state']  = '1';
           $arr['influ_ids'] = I('get.id','');
           $where['api'] = 'delAds';
           $where['webid'] = $web[0]['webid'];
           
           $oldids = $Api->where($where)->field('influ_ids')->find();
           if($oldids['influ_ids'])  $arr['influ_ids'].=','.$oldids['influ_ids'];
           
           $Api->where($where)->data($arr)->save();
           
           
           //更新首页静态文件
           $Web = M('website');
           $web = $Web->find($web[0]['webid']);
           $webid = $web[0]['webid'];
           $hd = fopen(WEB_ROOT.$web['filename'].'/index.html','w');
           $content = file_get_contents('http://'.$_SERVER['HTTP_HOST'].$web['filename'].'/index.php?webid='.$webid);
           fwrite($hd,$content);
           fclose($hd);
           
           if($Ads->where($data)->delete()){
               echo json_encode(array('state'=>0,'msg'=>'删除成功'));
           }else{
               echo json_encode(array('state'=>1,'msg'=>'删除失败'));
           }
           
           
           
       }
   }
   public function _empty(){
       $this->Public = new PublicController();
       $this->Public->show404();
       
   }
    
}
?>
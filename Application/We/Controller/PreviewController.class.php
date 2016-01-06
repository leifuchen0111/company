<?php 
namespace We\Controller;
use Think\Controller;
class PreviewController extends Controller{
    public function __construct(){
        parent::__construct();
        $Public = new PublicController();
        $Public->checkLogin();
    }
    
    public function QRcode(){
        $Web = D('Website');
        $webid = I('get.webid','');
        $query = $Web->field('filename')->getById($webid);
        
        $data = 'http://'.$_SERVER['HTTP_HOST'].$query['filename'].'/index.php?webid='.$webid;
        // 纠错级别：L、M、Q、H
        $level = 'L';
        // 点的大小：1到10,用于手机端4就可以了
        $size = 4;
        vendor("phpqrcode.phpqrcode");
        \Think\QR\QRcode::png($data, false, $level, $size);      
    }
    
    public function showQRcode(){
        $Web = D('Website');
        $webid = I('get.webid','');
        $query = $Web->field('filename')->getById($webid);
      
        $url = 'http://'.$_SERVER['HTTP_HOST'].$query['filename'].'/index.php?webid='.$webid;
        $this->assign('url',$url);
        
        $Public = new PublicController();
        $Public->showHeader();
        $this->display('Public/QRcode');
        $Public->showFooter();
    }
    
    /**
     * 404
     */
    public function _empty(){
        $Public = new PublicController();
        $Public->show404();
    }
}
?>
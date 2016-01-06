<?php 
namespace We\Controller;
use Think\Controller;
class ImgController extends Controller{
    public function __construct(){
        parent::__construct();
        $Public = new PublicController();
        $Public->checkLogin();
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
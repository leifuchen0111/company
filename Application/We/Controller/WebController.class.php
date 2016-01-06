<?php
namespace We\Controller;
use Think\Controller;
class WebController extends Controller{
    public function __construct(){
        parent::__construct();
        $Public = A('Public');
        $Public->checkLogin();
    } 
    public function getTitle(){
        
        $id = I('get.id','');
        $Web = M('website');
        $query = $Web->where('id='.$id)->find();
        $this->ajaxReturn($query);
    }
    
    /**
     * 404
     */
    public function _empty(){
       
        $Public = new PublicController();
        $Public->show404();
    }
}

<?php
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $id = I('param.id','');
        $gw_id = I('param.gw_id','');
        if(empty($id) && empty($gw_id))
        {
            R('Home/Public/showHeader');
            R('Home/Public/showFooter');
        }
        else
        {
            layout('Layout/layoutdetail');
            R('Public/showDetailHeader');
            R('Public/showDetailFooter');
        }




    }


}
<?php
namespace Train\Controller;
use Think\Controller;
class BaseController extends Controller
{
    public function __construct(){
        parent::__construct();
        R('Tool/Tool/checkLogin');
        $this->header();
    }

    public function header(){
        $nav = C('NAV');
        $gw_id = I('get.gw_id');
        $webid = I('get.webid','');

        $this->webid = $webid;
        $this->nav = $nav;
        $this->gw_id = $gw_id;

    }
}
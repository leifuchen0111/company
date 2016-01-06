<?php
namespace Catering\Controller;

use Think\Controller;

class BaseController extends Controller
{
    public function __construct(){
        parent::__construct();
        R('Tool/Tool/checkLogin');
        $_prefix = C('db_prefix');
        if(!$_SESSION['web']) {
            C('db_prefix', 'rou_');
            $_SESSION['web'] = M('website')->find(I('param.webid', 0));
            C('db_prefix', $_prefix);
        }
        $this->savePath = $filepath = urlencode(str_replace('/','.',$_SESSION['web']['filename'].'/resource'));
        $this->types = C('TYPE');

        $this->type = I('get.type','');
        $this->header();
    }

    public function header(){
        $nav = C('NAV');
        $gw_id = I('param.gw_id');
        $webid = I('param.webid','');

        $this->webid = $webid;
        $this->nav = $nav;
        $this->gw_id = $gw_id;

    }
}
<?php
/**
 * Created by PhpStorm.
 * User: lfc
 * Date: 2015/11/26
 * Time: 14:53
 */

namespace Singlepage\Controller;

class IndexController extends BaseController
{

    public function __construct(){

        parent::__construct();
        C('DB_PREFIX','rou_');
    }

    public function index(){

        $Web = M('website');
        $id = I('get.webid','');
        $web = $Web->find($id);

        $this->data = $web;
        $this->display();
    }

    public function save(){

        $Web = D('website');
        if(!$Web->create()){
            $this->error('数据错误');
        }
        $id = $Web->id;
        if($Web->save()){
            updateApi($id,'getBaseConf','');
            $this->success('资料修改成功');
        }else{
            $this->error('资料修改失败');
        }

    }

}
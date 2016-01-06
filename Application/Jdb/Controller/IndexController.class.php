<?php
/**
 * Created by PhpStorm.
 * User: lfc
 * Date: 2015/12/28
 * Time: 14:43
 */

namespace Jdb\Controller;


class IndexController extends BaseController
{
    public function index()
    {
        $Web = M('website');
        $webid = I('get.webid','');

        $data = $Web->find($webid);

        $this->data = $data;
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
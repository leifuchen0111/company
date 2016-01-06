<?php
namespace Home\Controller;
use Think\Controller;
class ApconfController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        R('Tool/Tool/checkLogin');
        $gw_id = I('param.gw_id', '');
    }
    //配置信息
    public function baseConf()
    {
        $ApConf = D('Apconf');
        $gw_id =  I('get.gw_id', '');
        if (!$gw_id) {
            $this->error('该路由器未注册');
        }

        $data = $ApConf->getOne($gw_id);
        $filepath = urlencode('.Uploads.qrcode');

        $this->assign('gw_id', $gw_id);
        $this->assign('data', $data);
        $this->assign('filepath',$filepath);

        $this->display('Apconf/apConf');

    }
    //修改配置
    public function baseConfEdit()
    {
        $ApConf = D('Apconf');
        $ApConf->create();
        if($qrcode = $this->getFilePath())
        {
            $ApConf->qrcode = $qrcode;
        }
        if ($ApConf->save()) {
            $this->success('修改成功');
        } else {
            $this->error('修改失败');
        }
    }

    protected function getFilePath(){
        $path = I('param.path');
        $filename = I('param.filename');
        if(!empty($path) && !empty($filename)){
            return $path.$filename;
        }

    }

    /**
     * 404
     */
    public function _empty()
    {
        R('Tool/Tool/show404');
    }
}
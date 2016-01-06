<?php
/**
 * 自媒体模板管理
 */
namespace Home\Controller;

use Think\Controller;
class WebMediaController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        R('Tool/Tool/checkLogin');
    }
    /**
     * 模板列表
     */
    public function modelList()
    {
        $Model = M('mediamodel');
        $models = $Model->select();
        $this->assign('models', $models);

        $this->display('Model/modelList');
    }
    /**
     * 模板上传
     */
    public function upModel()
    {
        if (IS_POST) {
            var_dump($_POST);
            var_dump($_FILES);
        } else {

            $this->display('Model/modelAdd');
        }
    }
    public function _empty()
    {
        R('Tool/Tool/show404');
    }
}
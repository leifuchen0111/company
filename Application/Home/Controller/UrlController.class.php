<?php
namespace Home\Controller;

use Think\Controller;
class UrlController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        R('Tool/Tool/checkLogin');
    }

    //url白名单
    public function urlWhite()
    {
        $id = I('get.gw_id', '');
        $Public = A('Public');
        $Url = D('Urllimit');

        $urlList = $Url->getWhiteList($id);

        $this->assign('urllist', $urlList);

        $this->display('Url/urlWhiteList');

    }
    /**
     * 添加URL白名单
     */
    public function urlWhiteAdd()
    {
        $Public = A('Public');
        $Urllimit = D('Urllimit');
        if (IS_POST) {
            if(!$Urllimit->create())
            {
                $this->error($Urllimit->getError());
            }
            if($Urllimit->add())
            {
                $this->success('添加成功');
            }
            else
            {
                $this->error('添加失败');
            }

        } else {
            $this->assign('utype',1);
            $this->display('Url/urlAdd');

        }
    }
    /**
     * @example 推送URL
     */
    public function appUrl()
    {
        $api = 'getWhiteUrl';
        $gwId = I('get.gw_id','');
        $ApApi = D('ApApi');
        if($ApApi->setYes($gwId,$api))
        {
            $this->setUrlFile($gwId);
            $this->success('操作成功，正在推送');
        }
        else
        {
            $this->error('已经在推送队列，请勿重复操作');
        }
    }
    public function del()
    {
        $gwId = I('get.gw_id');
        $Url = D('Urllimit');
        $map['id'] = array('in',I('get.id',''));
        if($Url->where($map)->delete())
        {
            $this->ajaxReturn(array('state'=>0,'msg'=>'删除成功'));
        }
        else
        {
            $this->ajaxReturn(array('state'=>1,'msg'=>'删除失败'));
        }

    }
    /**
     * @example 生成wifi配置文件
     * @param $gw_id 路由器gw_id
     * @param $flag 是否删除非通用设置
     */
    protected function setUrlFile($gwId)
    {
        $Url = D('Urllimit');
        $data = $Url->getWhiteList($gwId);
        $path = WEB_ROOT . '/RouteConf_File/' . $gwId . '/';
        $fileName = 'url.conf';
        if (!is_dir($path)) {
            mkdir($path,0777,true);
        }
        $hd = fopen($path . $fileName, 'w');
        foreach ($data as $item) {
            fwrite($hd, $item['url'].PHP_EOL);
        }
        fclose($hd);
    }
    /**
     * 404
     */
    public function _empty()
    {
        R('Tool/Tool/show404');
    }
}
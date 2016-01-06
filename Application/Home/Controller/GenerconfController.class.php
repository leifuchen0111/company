<?php
/**
 * 通用配置
 */
namespace Home\Controller;

use Think\Controller;
class GenerconfController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        R('Tool/Tool/checkLogin');
        R('Public/checkAcess', array('actName' => ACTION_NAME));
    }
    //通用url黑名单列表
    public function urlblack()
    {
        $Public = A('Public');
        $data['utype'] = '0';
        $userId = session('userId');
        $Url = D('Urlwb');
        $url = $Url->where(array('uid' => $userId, 'rid' => 0, 'utype' => '0'))->select();
        $this->assign('data', $data);
        $this->assign('urllist', $url);
        $Public->showHeader();
        $this->display('Ap/urlList');
        $Public->showFooter();
    }
    //通用url白名单列表
    public function urlwhite()
    {
        $Public = A('Public');
        $userId = session('userId');
        $Url = D('Urlwb');
        $url = $Url->where(array('uid' => $userId, 'rid' => 0, 'utype' => '1'))->select();
        $data['utype'] = '1';
        $this->assign('data', $data);
        $this->assign('urllist', $url);
        $Public->showHeader();
        $this->display('Ap/urlList');
        $Public->showFooter();
    }
    //通用mac白名单列表
    public function macwhite()
    {
        $data['type'] = '1';
        $Public = A('Public');
        $userId = session('userId');
        $Mac = D('Macwblist');
        $mac = $Mac->where(array('uid' => $userId, 'rid' => 0, 'mtype' => '1'))->select();
        $this->assign('data', $data);
        $this->assign('maclist', $mac);
        $Public->showHeader();
        $this->display('Mac/macList');
        $Public->showFooter();
    }
    //通用mac黑名单列表
    public function macblack()
    {
        $data['type'] = '0';
        $Public = A('Public');
        $userId = session('userId');
        $Url = D('Macwblist');
        $url = $Url->where(array('uid' => $userId, 'rid' => 0, 'mtype' => '0'))->select();
        $this->assign('data', $data);
        $this->assign('urllist', $url);
        $Public->showHeader();
        $this->display('Ap/macList');
        $Public->showFooter();
    }
    //删除mac黑/白名单
    public function delMac()
    {
        $mid = I('get.mid', '');
        $redirect = array('0' => 'Generconf/macblack', '1' => 'Generconf/macwhite');
        $Mac = D('Macwblist');
        if ($Mac->delete($mid)) {
            $this->success('删除成功', U($redirect[I('get.type', '')]) . '?' . uniqid());
        } else {
            $this->error('删除失败');
        }
    }
    //添加mac黑/白名单
    public function addMac()
    {
        $Public = A('Public');
        $redirect = array('0' => 'Generconf/macblack', '1' => 'Generconf/macwhite');
        if ($_POST) {
            $Mac = D('Macwblist');
            $data['mac'] = I('post.mac', '');
            $data['uid'] = session('userId');
            $data['updtime'] = time();
            $data['mtype'] = I('post.type', '0');
            $result = $Mac->data($data)->add();
            if ($result) {
                $this->success('添加成功', U('Generconf/macWhite'));
            } else {
                $this->error('添加失败');
            }
        } else {
            $html['type'] = I('get.type', '');
            $this->assign('data', $html);
            $Public->showHeader();
            $this->display('Mac/macEdit');
            $Public->showFooter();
        }
    }
    //删除url黑/白名单
    public function delUrl()
    {
        $mid = I('get.mid', '');
        $type = I('get.type', '');
        $redirect = array('0' => 'Generconf/urlblack', '1' => 'Generconf/urlwhite');
        $Mac = D('Urlwb');
        if ($Mac->delete($mid)) {
            $this->success('删除成功', U($redirect[$type]) . '?' . uniqid());
        } else {
            $this->error('删除失败');
        }
    }
    //添加url黑/白名单
    public function addUrl()
    {
        $Public = A('Public');
        $redirect = array('0' => 'Generconf/urlblack', '1' => 'Generconf/urlwhite');
        if ($_POST) {
            $Mac = D('Urlwb');
            $Mac->create();
            $Mac->uid = session('userId');
            if ($Mac->add()) {
                $this->success('添加成功', U($redirect[I('post.utype', '')]) . '?' . uniqid());
            } else {
                $this->error('添加失败');
            }
        } else {
            $data['type'] = I('get.type', '');
            $this->assign('data', $data);
            $Public->showHeader();
            $this->display('Ap/urlEdit');
            $Public->showFooter();
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
<?php
/**
 * 仪表盘详情
 */
namespace Home\Controller;

use Think\Controller;
class DashboardController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        R('Tool/Tool/checkLogin');
    }
    /**
     * mac历史记录
     */
    public function visitor()
    {
        $macs = R('Public/treeMac', array('uid' => session('userId'))); 
        //历史用户
        $this->assign('macVisitHistory', $macs['history']);
        //在线用户
        R('Public/showHeader');
        R('Public/showFooter');
        $this->display('Dashboard/visitHistory');
    }
    /**
     * mac 在线
     */
    public function user()
    {
        $start = '';
        if(isset($_GET['start']) && !empty($_GET['start'])){
            $start = I('get.start','');
        }
        $User = D('User');
        $user = $User->getUserList(session('userId'));

        $ApMain = D('ApMain');
        $ap = $ApMain->getApList($user);

        $Mac = D('mac');
        $count = $Mac->getMacCount($ap,$start);

        $Page = new \Think\Page($count,10);
        $show = $Page->show();
        $macs = D('mac')->getMacList($ap,$Page,$start);

        $this->assign('page',$show);
        $this->assign('maclist', $macs);

        $this->display('Dashboard/online');
    }
    /**
     * 会员管理
     */
    public function member()
    {
        $pid = I('get.pid','');
        $pid = $pid==''?session('userId'):$pid;

        $Member = D('user');
        $count = $Member->getMemberCount($pid);
        $Page = new \Think\Page($count,10);
        $show = $Page->show();

        $member = $Member->getMemberList($Page,$pid);
        $this->assign('page',$show);
        $this->assign('member',$member);

        $this->display();
    }

    /**
     * 发布系统消息
     */
    public function postSysnews()
    {
        //默认管理员才能发布系统消息
        if (session('userId') != 1) {
            R('Public/show404');
        }
        if (IS_POST) {
            $Sysnew = M('sysnews');
            $Sysnew->create();
            $Sysnew->uid = session('userId');
            $Sysnew->posttime = time();
            $Sysnew->content = $_POST['content'];
            if ($Sysnew->add()) {
                $this->success('消息发布成功！');
            } else {
                $this->error('消息发布失败');
            }
        } else {

            $this->display();
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
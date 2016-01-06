<?php
/**
 * 用户个人管理
 */
namespace Home\Controller;
use Think\Controller;
class UserController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        R('Tool/Tool/checkLogin');

    }
    /**
     * 用户个人信息显示
     */
    public function profileSave()
    {
        $User = D('user');
        $UserInfo = D('userinfo');
        $pwd = I('post.pass','');
        $wx_id = I('post.wx_id', '');

        if (!($data = $User->create('',2))) {
            $this->error($User->getError());
        }
        if($pwd) $_POST['pwd'] = true;
        $data = array_intersect_key($data,$_POST);
        $result1 = $User->save($data);

        $map = array(
            'userid' => $data['id']
        );
        $data = array(
            'wx_id' => $wx_id
        );
        $result2 = $UserInfo->where($map)->save($data);

        if($result1 || $result2){
            $this->success('个人信息修改成功');
        }else{
            $this->error('个人信息修改失败');
        }
    }

    public function profile()
    {
        $User = D('user');
        $UserInfo = M('userinfo');
        $id = session('userId');

        $wxid = $UserInfo->getFieldByUserid($id, 'wx_id');
        $profile = $User->find($id);

        $this->assign('wx_id',$wxid );
        $this->assign('user', $profile);
        $this->display();
    }

    /**
     * 404
     */
    public function _empty()
    {
        R('Tool/Tool/show404');
    }
}
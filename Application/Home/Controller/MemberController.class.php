<?php
/**
 * 用户管理
 * @author bpm
 *
 */
namespace Home\Controller;

use Think\Controller;
class MemberController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        R('Tool/Tool/checkLogin');
       // R('Public/checkAcess', array('actName' => ACTION_NAME));
        $html['open'] = MODULE_NAME;
        $this->assign('html', $html);
    }
    //运营商
    public function agent()
    {
        $user = D('User')->getUserList();
        $this->assign('agentList', $user);

        $this->display('Member/agentList');
    }
    //添加运营商
    public function addAgent()
    {
        $Public = A('Public');
        $User = D('User');
        if ($_POST) {
            if (!$User->create()) {
                $this->error($User->getError());
            }
            if ($User->getByName(I('post.name', ''))) {
                $this->error('用户名已存在');
            }
            $User->pid = session('userId');
            $User->startTrans();
            $User->is_ok = '2';
            $id = $User->add();
            if ($id) {
                $data = array();
                $data['userid'] = $id;
                $Uinfo = M('userinfo');
                if ($Uinfo->data($data)->add()) {
                 //   F(session('name', '/member'), null);
                    $User->commit();
                    $this->success('添加成功!', 'agent');
                } else {
                    $this->error('添加失败');
                }
            } else {
                $this->error('添加失败');
            }
        } else {
            $Role = D('role');
            $role = $Role->where(array('id' => array('neq', 1), 'role' => array('neq', '商户')))->select();
            $this->assign('role', $role);

            $this->display('Member/agentEdit');

        }
    }
    //批量删除运营商
    public function delAgent()
    {
        if (IS_AJAX) {
            $Member = D('user');
            $data['id'] = array('in', I('get.id'));
            if ($Member->where($data)->delete()) {
                F(session('name', '/member'), null);
                echo json_encode(array('state' => 0, 'msg' => '运营删除成功'));
            } else {
                echo json_encode(array('state' => 1, 'msg' => '删除失败'));
            }
        }
    }
    //批量删除商户
    public function delUsers()
    {
        if (IS_AJAX) {
            $Member = D('user');
            $data['id'] = array('in', I('get.id'));
            if ($Member->where($data)->delete()) {
                F(session('name', '/member'), null);
                echo json_encode(array('state' => 0, 'msg' => '会员删除成功'));
            } else {
                echo json_encode(array('state' => 1, 'msg' => '删除失败'));
            }
        }
    }
    //批量编辑运营商
    public function editAgent()
    {
        $Public = A('Public');
        $Member = D('User');
        if (IS_GET) {
            $Role = D('Role');
            $roles = $Role->select();
            $this->assign('role', $roles);
            $data['id'] = array('in', I('get.id', ''));
            $members = $Member->where($data)->select();
            $this->assign('member', $members);
            $Public->showHeader();
            $this->display('Member/editAgents');
            $Public->showFooter();
        }
        if (IS_POST) {
            $data = array();
            //多个用户信息整理
            foreach ($_POST as $k => $v) {
                $k = explode('_', $k);
                $data[$k[1]][$k[0]] = $v;
            }
            //记录修改成功后的ID
            $successId = '';
            //逐个修改信息
            foreach ($data as $k => $v) {
                $arr = array();
                $arr = $v;
                $id = $arr['id'] = $k;
                $arr['role_id'] = $v['roleid'];
                unset($arr['roleid']);
                if (!$arr['password']) {
                    unset($arr['password']);
                    unset($arr['repassword']);
                }
                if ($arr['password'] != $arr['repassword']) {
                    $this->error('两次输入密码不一致');
                }
                unset($arr['repassword']);
                $arr['address'] = $v['address'];
                $arr['phone'] = $v['phone'];
                $arr['email'] = $v['email'];
                $arr['pwd'] = substr(md5($v['password']), 1, 30);
                unset($arr['password']);
                if (!$Member->data($arr)->save()) {
                    $this->error('只有ID为' . $successId . '的修改成功');
                } else {
                    $successId += $k + ',';
                }
            }
            $this->success('修改成功', 'agent');
        }
    }
    //批量编辑商户
    public function editUser()
    {
        $Public = A('Public');
        $Member = D('User');
        if (IS_GET) {
            $Role = D('Role');
            $roles = $Role->select();
            $this->assign('role', $roles);
            $data['id'] = array('in', I('get.id', ''));
            $members = $Member->where($data)->select();
            $this->assign('member', $members);

            $this->display('Member/editUsers');

        }
        if (IS_POST) {
            $data = array();
            //数据重组
            foreach ($_POST as $k => $v) {
                $k = explode('_', $k);
                $data[$k[1]][$k[0]] = $v;
            }
            foreach ($data as $k => $v) {
                $arr = array();
                $arr = $v;
                $arr['id'] = $k;
                if (!$arr['password']) {
                    unset($arr['password']);
                    unset($arr['repassword']);
                }
                if (!$Member->create($arr)) {
                    $this->error($Member->getError());
                }
                if (!$Member->save()) {
                    $this->error('只有部分信息修改成功');
                }
            }
            $this->success('修改成功', 'user');
        }
    }
    //添加商户
    public function addUser()
    {
        $Public = A('Public');
        $User = D('User');
        if ($_POST) {
            if (!$User->create()) {
                $this->error($User->getError());
            }
            if ($User->getByName(I('post.name', ''))) {
                $this->error('用户名已存在');
            }
            $User->pid = session('userId');
            $User->role_id = 3;
            $User->is_ok = '2';
            $id = $User->add();
            if ($id) {
                $data = array();
                $data['userid'] = $id;
                $Uinfo = M('userinfo');
                $Uinfo->data($data)->add();
                F(session('name', '/member'), null);
                $this->success('添加成功', U('Member/user'));
            } else {
                $this->error('添加失败');
            }
        } else {
            $Public->showHeader();
            $this->display('Member/userAdd');
            $Public->showFooter();
        }
    }
    //会员管理
    public function user()
    {
        $Public = A('Public');
        $user = $Public->treeUser($_SESSION['userId']);
        if (in_array('addUser', $_SESSION['actions'])) {
            $htmluser['addUser'] = 1;
        }
        if (in_array('delUser', $_SESSION['actions'])) {
            $htmluser['delUser'] = 1;
        }
        if (in_array('editUser', $_SESSION['actions'])) {
            $htmluser['editUser'] = 1;
        }
        if (in_array('banUser', $_SESSION['actions'])) {
            $htmluser['banUser'] = 1;
        }

        $this->assign('htmlUser', $htmluser);
        $this->assign('userList', $user['user']);

        $this->display('Member/userList');

    }
    /**
     * 关于新注册用户审核
     */
    public function auditUser()
    {
        $Public = A('Public');
        $User = D('User');
        $data['pid'] = session('userId');
        $data['is_ok'] = '0';
        $userAuditLits = $User->where($data)->select();
        $this->assign('userAuditList', $userAuditLits);
        $Public->showHeader();
        $this->display('Member/userAuditList');
        $Public->showFooter();
    }
    /**
     * 通过/驳回 新用户注册请求
     */
    public function audit()
    {
        if (IS_AJAX) {
            $User = $User = D('User');
            $flag = array('pass' => '2', 'refuse' => '1');
            $data['id'] = array('in', I('post.id', ''));
            $data['is_ok'] = $flag[$_POST['act']];
            $query = $User->save($data);
            if ($query) {
                if ($data['is_ok'] == 2) {
                    $id_str = I('post.id', '');
                    $id = explode(',', $id_str);
                    $UserInfo = M('userinfo');
                    foreach ($id as $item) {
                        $userInfo = array();
                        $userInfo['userid'] = $item;
                        $UserInfo->data($userInfo)->add();
                    }
                }
                echo json_encode(array('state' => 0, 'msg' => '操作成功'));
            } else {
                echo json_encode(array('state' => 1, 'msg' => '操作失败'));
            }
        }
        if (IS_GET) {
            $User = D('User');
            $flag = array('pass' => '2', 'refuse' => '1');
            $data['id'] = I('get.id', '');
            $data['is_ok'] = $flag[I('get.act', '')];
            $query = $User->save($data);
            if ($query) {
                if ($data['is_ok'] == 2) {
                    $UserInfo = M('userinfo');
                    $userInfo = array();
                    $userInfo['userid'] = $data['id'];
                    $UserInfo->data($userInfo)->add();
                }
                $this->success('操作成功', U('Member/auditUser'));
            } else {
                $this->error('操作失败');
            }
        }
    }
    /**
     * 待审核用户详细信息查看
     */
    public function userAuditInfo()
    {
        $Public = A('Public');
        $userid = I('get.id', '');
        $Member = D('User');
        $user = $Member->relation('role')->getById($userid);
        //hn   var_dump($user);
        $this->assign('user', $user);
        $Public->showHeader();
        $this->display('Member/userAuditEdit');
        $Public->showFooter();
    }
    /**
     * 404
     */
    public function _empty()
    {
        R('Tool/Tool/show404');
    }
}
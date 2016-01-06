<?php
/**
 * 角色管理
 */
namespace Home\Controller;

use Think\Controller;
class RoleController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        R('Tool/Tool/checkLogin');
      //  R('Public/checkAcess', array('actName' => ACTION_NAME));
        $html['open'] = MODULE_NAME;
        $this->assign('html', $html);
    }
    public function listRole()
    {
        $Public = A('Public');
        $Role = D('Role');
        $Member = D('User');
        //判断是否现在添加、编辑或删除按钮
        if (in_array('addRole', $_SESSION['actions'])) {
            $htmluser['addRole'] = 1;
        }
        if (in_array('delRole', $_SESSION['actions'])) {
            $htmluser['delRole'] = 1;
        }
        if (in_array('editRole', $_SESSION['actions'])) {
            $htmluser['editRole'] = 1;
        }
        $this->assign('htmlUser', $htmluser);
        $role = $Role->where(array('id' => array('neq', 1), 'uid' => session('userId')))->select();
        //统计各角色下用户数
        foreach ($role as &$item) {
            $item['count'] = $Member->where(array('role_id' => $item['id']))->count();
        }
        $this->assign('role', $role);

        $this->display('Role/roleList');

    }
    /**
     * 编辑角色权限
     */
    public function editRole()
    {
        $Public = A('Public');
        // var_dump($Public->getAllActions());die;
        $R_A = M('act_role');
        if (IS_POST) {
            $acts = I('post.act', '');
            $data['r_id'] = I('post.role_id', '');
            //    var_dump($acts);die;
            $R_A->where($data)->delete();
            $len = count($acts);
            $R_A->startTrans();
            for ($i = 0; $i < $len; $i++) {
                $data['a_id'] = $acts[$i];
                if (!$R_A->data($data)->add()) {
                    $R_A->rollback();
                    $this->error('编辑失败');
                    die;
                }
            }
            $R_A->commit();
            $this->success('编辑成功', U('Role/listRole'));
        } else {
            $data['id'] = I('get.id', '');
            $role = $R_A->where(array('r_id' => $data['id']))->field('a_id')->select();
            $a_id = array();
            foreach ($role as $item) {
                array_push($a_id, $item['a_id']);
            }
            $data['a_id'] = $a_id;
            $this->assign('id', $data);
            $this->assign('haveAction', $a_id);
            $this->assign('actions', $Public->getAllActions());
            $this->display('Role/jurisdiction');
        }
    }
    /**
     * 添加角色
     */
    public function addRole()
    {
        $Public = A('Public');
        $Role = D('Role');
        if (IS_POST) {
            if (!$Role->create()) {
                $this->error($Role->getError());
            }
            $Role->uid = session('userId');
            if ($Role->add()) {
                $this->success('添加成功', U('Role/listRole'));
            } else {
                $this->error('添加失败');
            }
        } else {

            $this->display('Role/roleAdd');

        }
    }
    /**
     * 删除角色
     */
    public function delRole()
    {
        if (IS_AJAX) {
            $Role = D('Role');
            $data['id'] = array('in', I('get.id', ''));
            $User = D('User');
            $User->where(array('role_id' => array('in', I('get.id', ''))))->delete();
            if ($Role->where($data)->delete()) {
                echo json_encode(array('state' => 0, 'msg' => '删除成功'));
            } else {
                echo json_encode(array('state' => 1, 'msg' => '删除失败'));
            }
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
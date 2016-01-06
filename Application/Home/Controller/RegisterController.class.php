<?php
namespace Home\Controller;

use Think\Controller;
class RegisterController extends Controller
{
    /**
     * 注册
     */
    public function register()
    {
        $this->display('Register/register');
    }
    public function toRegister()
    {
        if (IS_POST) {
            $User = D('User');
            $data = $User->create();
            //图片上传
            $img_type = array('image/png', 'image/gif', 'image/jpeg');
            $type = array('image/png' => '.png', 'image/gif' => '.gif', 'image/jpeg' => '.jpg');
            if (!in_array($_FILES['organization_img']['type'], $img_type) || !in_array($_FILES['business_img']['type'], $img_type)) {
                $this->error('文件格式不对');
            }
            $upload_path = WEB_ROOT . '/Uploads/images/' . $data['name'];
            if (!is_dir($upload_path)) {
                mkdir($upload_path, '0777', true) or die('目录创建失败');
            }
            move_uploaded_file($_FILES['business_img']['tmp_name'], $upload_path . '/business' . $type[$_FILES['business_img']['type']]) or $this->error('文件上传失败');
            move_uploaded_file($_FILES['organization_img']['tmp_name'], $upload_path . '/organization' . $type[$_FILES['organization_img']['type']]) or $this->error('文件上传失败');
            $data['business_img'] = '/Uploads/images/' . $data['name'] . '/business' . $type[$_FILES['business_img']['type']];
            $data['organization_img'] = '/Uploads/images/' . $data['name'] . '/organization' . $type[$_FILES['business_img']['type']];
            $id = $User->data($data)->add();
            if ($id) {
                $data = array();
                $data['userid'] = $id;
                $Uinfo = M('userinfo');
                $Uinfo->data($data)->add();
                $this->success('你的资料已成功提交,审核通过后将通过短信方式提醒你', U('Public/Login'));
            } else {
                $this->error('资料提交失败');
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
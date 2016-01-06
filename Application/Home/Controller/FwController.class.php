<?php
/**
 * 固件管理
 */
namespace Home\Controller;

use Think\Controller;
class FwController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        R('Tool/Tool/checkLogin');
//        R('Public/checkAcess', array('actName' => ACTION_NAME));
        $html['open'] = MODULE_NAME;
        $this->assign('html', $html);
    }
    public function fwHistory()
    {

        $Fw = D('Fw');
        $fws = $Fw->join('LEFT JOIN `rou_fw_apmode` ON rou_fw_apmode.`fw_id`=rou_fw.`id`')->field('rou_fw.*,rou_fw_apmode.`apmode` as mode')->select();
        $this->assign('fw', $fws);

        $this->display('Fw/fwList');

    }
    /**
     * 固件上传
     */
    public function fwUpload()
    {
        $ApMain = D('ApMain');
        $Public = A('Public');
        if (IS_POST) {
            $arr = explode('_', $_FILES['fw']['name']);
            //   var_dump($_FILES);
            $data['version'] = $arr[2];
            $data['file_md5'] = $arr[3];
            $data['file_name'] = $arr[0] . '_' . $arr[1];
            $data['desc'] = I('post.desc', '');
            move_uploaded_file($_FILES['fw']['tmp_name'], WEB_ROOT . '/FwDownload/' . $_FILES['fw']['name']) or die('文件移动失败');
            $Fw = D('Fw');
            $Fw->create($data);

            if ($Fw->add()) {
                $mode_fw = array();
                $mode_fw['fw_id'] = $Fw->getLastInsID();
                $mode = I('post.mode', '');
                $count = count($mode);
                for ($i = 0; $i < $count; $i++) {
                    $mode_fw['apmode'] = $mode[$i];
                    if (!is_string($mode_fw['apmode']) || !$mode_fw['apmode']) {
                        continue;
                    }
                    if (!M('fw_apmode')->data($mode_fw)->add()) {
                        $this->error('上传失败，请联系技术员解决');
                    }
                }
                $this->success('上传成功');
            } else {
                unlink(SERVER_ROOT . '/FwDownload/' . $data['file_name']);
                $this->error('上传失败');
            }
        } else {
            $type = $ApMain->field('mode')->group('mode')->select();
            $type2 = M('fw_apmode')->field('apmode mode')->group('apmode')->select();
            foreach ($type2 as $v) {
                array_push($type, $v);
            }
            $alltype = array();
            foreach ($type as $v) {
                if (!empty($v['mode'])) {
                    $alltype[] = $v['mode'];
                }
            }
            $alltype = array_unique($alltype);
            sort($alltype);
            $len = count($alltype);
            $newtype = array();
            for ($i = 0; $i < $len; $i++) {
                $newtype[$i]['mode'] = $alltype[$i];
            }
            $this->assign('mode', $newtype);

            $this->display('Fw/fwEdit');

        }
    }
    /**
     * 固件检测并更新
     */
    public function FwCheckUpd()
    {
        $Public = A('Public');
        $Ap = D('ApMain');
        $Fw = D('Fw');
        if (IS_POST && $_POST['id']) {
            $data['id'] = array('in', I('post.id'), '');
        }
        $data['isupgrade'] = array('neq', '1');
        $needUpdateAp = $Ap->field('id,mode')->where($data)->select();
	foreach ($needUpdateAp as $item) {
            $data = array();
            $data['isupgrade'] = '1';
            $data['id'] = $item['id'];
            if (!$Ap->save($data)) {
                if (IS_AJAX) {
                    echo json_encode(array('state' => 1, 'msg' => '更新失败'));
                    die;
                }
                $this->error('更新失败');
            }
        }
        if (IS_AJAX) {
            echo json_encode(array('state' => 0, 'msg' => '所有AP已加入更新队列，稍后将自动为您更新'));
            die;
        }
        $this->success('所有AP已加入更新队列，稍微自动为您更新', '', 5);
    }
    /**
     * 404
     */
    public function _empty()
    {
        R('Tool/Tool/show404');
    }
}

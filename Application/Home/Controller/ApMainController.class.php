<?php
namespace Home\Controller;
use Org\Util;
class ApMainController extends BaseController
{
    protected $Execl_Error = array('数据导入成功', '找不到文件', 'Execl文件格式不正确');
    protected $ApMain;
    public function __construct()
    {
        parent::__construct();
        R('Tool/Tool/checkLogin');
        $html['open'] = MODULE_NAME;
        $this->assign('html', $html);
    }
    /**
     * 管理首页
     */
    public function index()
    {
        $Sysnew = M('sysnews');
        $news = $Sysnew->alias('n')->select();
        $this->assign('sysnews', $news);

        $this->display('Dashboard/sysnews');
    }
    /**
     * @example 恢复出厂设置 
     */
    public function reset()
    {
        $id = I('get.id', '');
        $result = D('ApMain')->where(array('id' => array('in', $id)))->data(array('istoreset' => '1'))->save();
        $result ? $this->success('重置中，请勿关闭电源') : $this->error('操作失败');
    }
    /**
     * AP列表
     */
    public function apList()
    {
        $User = D('user');
        $ApMain = D('ApMain');

        $UserList = $User->getUserList();

        $count = $ApMain->getApCount($UserList);
        $Page = new \Think\Page($count,10);
        $show = $Page->show();

        $ApList = $ApMain->getApList($UserList,$Page);

        $this->assign('page',$show);
        $this->assign('aplist', $ApList);

        $this->display('Ap/apList');
    }

    public function search(){
        $key = I('get.words','');
       // var_dump($key);
        $User = D('user');
        $ApMain = D('ApMain');

        $UserList = $User->getUserList();

        $count = $ApMain->getApCount($UserList,$key);
        $Page = new \Think\Page($count,5);
        $show = $Page->show();

        $ApList = $ApMain->getApList($UserList,$Page,$key);

        $this->assign('page',$show);
        $this->assign('aplist', $ApList);
        $this->assign('keys', $key);

        $this->display('Ap/apList');

    }

    /**
     * 重启路由器
     */
    public function restart()
    {
        if (IS_AJAX) {
            $ApMain = D('ApMain');
            $data['id'] = array('in', I('get.id', ''));
            $data['torestart'] = '1';
            $query = $ApMain->data($data)->save();
            if ($query) {
                json('重启成功','success');
            } else {
                json('重启失败','error');
            }
        }
    }
    /**
     * 单路由器基本信息
     */
    public function detail()
    {
        $rid = I('get.id', '');
        $fields = 'gw_id,id,fw,hwserial,create_time,devsize';

        $data['apDetail'] = D('ApMain')->field($fields)->getById($rid);
        $data['apnow'] = D('apnow')->getOne($data['apDetail']['gw_id']);
        $data['apConf'] = M('apconf')->getByGw_id($data['apDetail']['gw_id']);
        $data['current'] = D('mac')->getOnlineCountByOne($rid);

        $this->assign('data', $data);

        $this->display('Ap/apDetail');
    }
    /**
     *@example 将路由器分配给账号下子账号
     *
     */
    public function fenp()
    {
        $rid = I('post.rid', '');
        $name = I('post.name', '');
        $User = D('User');
        $ApMain = D('ApMain');

        $user = $User->where(array('pid' => session('userId'), 'name' => $name))->find();
        if (!$user) {
            json('用户不存在','error');
        }

        if(!$ApMain->distribute($rid,$name)){
            json('操作失败','error');
        }else{
            json('操作成功','success');

        }
    }

    public function recover()
    {
        if (IS_AJAX) {
            $id = I('get.id', '');
            $map = array();
            $data = array();

            $map['id'] = array('in',$id);
            $data['uid'] = session('userId');
            $result = M('ap_main')->where($map)->data($data)->save();

            $result ? $this->ajaxReturn(array('state' => 0, 'msg' => '操作成功')) : $this->ajaxReturn(array('code' => 1, 'msg' => '操作失败'));
        }
    }
    /**
     * excel导入
     */
    public function import()
    {
        //R('Public/checkAcess', array('actName' => ACTION_NAME));
        if (IS_POST) {
            if (isset($_FILES['import']) && $_FILES['import']['error'] == 0) {

                $result = $this->Import_Execl($_FILES['import']['tmp_name']);
                if ($this->Execl_Error[$result['error']] == 0) {
                    $execl_data = $result['data'][0]['Content'];

                    if ($execl_data[1][0] != 'hwserial') {
                        $this->error('excel表格式不对');
                    }
                    unset($execl_data[1]);
                    $ApMain = D('ApMain');
                    $ApMain->startTrans();
                    $insert_id = array();
                    if ($_SESSION['userId'] == 1) {
                        foreach ($execl_data as $k => $v) {
                            $data['hwserial'] = $v[0];
                            $data['fw'] = $v[1] ? $v[1] : '1.0.0';
                            $data['uid'] = session('userId');
                            if (!($insert_id[] = $ApMain->data($data)->add())) {
                                $ApMain->rollback();
                                $this->error('导入失败');
                            }
                        }
                    } else {
                        foreach ($execl_data as $k => $v) {
                            $data['hwserial'] = $v[0];
                            $ap = $ApMain->field('id')->getByHwserial($data['hwserial']);
                            if (!$ap) {
                                $ApMain->rollback();
                                $this->error('存在无效路由');
                            }
                            $data['id'] = $ap['id'];
                            $insert_id[] = $ap['id'];
                            $data['uid'] = session('userId');
                            if (!$ApMain->data($data)->save()) {
                                $ApMain->rollback();
                                $this->error('导入失败');
                            }
                        }
                    }
                    $ApMain->commit();
                    $this->success($this->Execl_Error[$result['error']]);
                } else {
                    $this->error($this->Execl_Error[$result['error']]);
                }
            } else {
                $this->error('上传文件失败');
            }
        } else {

            $this->display('Ap/apImport');
        }
    }
    /**
     *
     * @example 导入路由器
     * @param unknown $file
     * @return multitype:number |multitype:number multitype:multitype:mixed
     */
    protected function Import_Execl($file)
    {
        if (!file_exists($file)) {
            return array('error' => 1);
        }
        $PHPExcel = new \Org\Util\PHPExcel();
        $PHPReader = new \PHPExcel_Reader_Excel2007();
        if (!$PHPReader->canRead($file)) {
            $PHPReader = new \PHPExcel_Reader_Excel5();
            if (!$PHPReader->canRead($file)) {
                return array('error' => 2);
            }
        }
        $PHPExcel = $PHPReader->load($file);
        $SheetCount = $PHPExcel->getSheetCount();
        for ($i = 0; $i < $SheetCount; $i++) {
            $currentSheet = $PHPExcel->getSheet($i);
            $allColumn = $this->ExcelChange($currentSheet->getHighestColumn());
            $allRow = $currentSheet->getHighestRow();
            $array[$i]['Title'] = $currentSheet->getTitle();
            $array[$i]['Cols'] = $allColumn;
            $array[$i]['Rows'] = $allRow;
            $arr = array();
            for ($currentRow = 1; $currentRow <= $allRow; $currentRow++) {
                $row = array();
                for ($currentColumn = 0; $currentColumn < $allColumn; $currentColumn++) {
                    $row[$currentColumn] = $currentSheet->getCellByColumnAndRow($currentColumn, $currentRow)->getValue();
                }
                $arr[$currentRow] = $row;
            }
            $array[$i]['Content'] = $arr;
        }
        //spl_autoload_register(array('Think', 'autoload'));
        //必须的，不然ThinkPHP和PHPExcel会冲突
        unset($currentSheet);
        unset($PHPReader);
        unset($PHPExcel);
        unlink($file);
        return array('error' => 0, 'data' => $array);
    }
    protected function ExcelChange($str)
    {
        //配合Execl批量导入的函数
        $len = strlen($str) - 1;
        $num = 0;
        for ($i = $len; $i >= 0; $i--) {
            $num += (ord($str[$i]) - 64) * pow(26, $len - $i);
        }
        return $num;
    }
    /**
     * 404
     */
    public function _empty()
    {
        R('Tool/Tool/show404');
    }
}
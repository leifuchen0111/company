<?php
/**
 *@example 批量设置
 */
namespace Home\Controller;

use Think\Controller;
class BatchSetController extends Controller
{
    private $Public;
    private $Ssid;
    private $ApMian;
    private $WebSite;
    public function __construct()
    {
        parent::__construct();
        $this->Public = A('Public');
        $this->Ssid = D('Ssid');
        $this->ApMian = D('ApMain');
        $this->WebSite = D('Website');
        R('Tool/Tool/checkLogin');
    }
    /**
     * @example 批量设置首页
     */
    public function index()
    {
        $this->Public->showHeader();
        $this->display('Batch/index');
        $this->Public->showFooter();
    }
    /**
     * @example 批量添加热点
     */
    public function ssidAdd()
    {
        if (IS_POST) {
            if (!($data = $this->Ssid->create())) {
                $this->error($this->Ssid->getError());
            }
            $data['state'] = array('in', '0,1');
            //检测同名同频道的重复性
            if ($this->Ssid->field('id')->where($data)->find()) {
                $this->error('该频道下此热点已存在!');
            }
            unset($data['ssid']);
            //检测该频道热点个数不超过4个
            if ($this->Ssid->where($data)->count() >= 4) {
                $this->error('同一频道最多可以添加4个热点!');
            }
            $isDelAll = I('post.delAll', '');
            if ($this->Ssid->add()) {
                $gw_id = array();
                $gw_id = $this->ApMian->field('gw_id')->where(array('uid' => session('userId')))->select();
                foreach ($gw_id as $item) {
                    $this->setConfFile($item['gw_id'], $isDelAll);
                    $data = array();
                    $data['getssid'] = '1';
                    $this->ApMian->data($data)->where(array('gw_id' => $item['gw_id']))->save();
                }
                $this->success('您的操作已加入队列，请稍等2-3分钟');
            } else {
                $this->error('添加失败');
            }
        } else {
            $this->Public->showHeader();
            $this->display('Batch/ssidAdd');
            $this->Public->showFooter();
        }
    }
    /**
     * @热点列表
     */
    public function ssidList()
    {
        $ssids = $this->Ssid->where(array('gw_id' => session('userId') . '_c'))->select();
        $this->assign('ssid', $ssids);
        $this->Public->showHeader();
        $this->display('Batch/ssidList');
        $this->Public->showFooter();
    }
    /**
     * @example 自媒体管理
     */
    public function Weblist()
    {
        $weblist = $this->WebSite->where(array('uid' => session('userId')))->select();
        $this->assign('websites', $weblist);
        $this->Public->showHeader();
        $this->display('Batch/weblist');
        $this->Public->showFooter();
    }
    /**
     * @example 生成wifi配置文件
     * @param $gw_id 路由器gw_id
     */
    protected function setConfFile($gw_id, $flag = false)
    {
        $Ssid = M('ssid');
        $data['gw_id'] = array('in', $gw_id . ',' . session('userId') . '_c');
        if ($flag) {
            $Ssid->where(array('gw_id' => $gw_id))->delete();
            $data['gw_id'] = session('userId') . '_c';
        }
        $ssidList = $Ssid->where($data)->select();
        $path_wireless = WEB_ROOT . '/RouteConf_File/' . $gw_id . '/';
        if (!is_dir($path_wireless)) {
            mkdir($path_wireless);
        }
        $hd = fopen($path_wireless . 'wireless.conf', 'w');
        foreach ($ssidList as $item) {
            fwrite($hd, 'freq=' . $item['channel'] . ' ssid="' . $item['ssid'] . '" pwd="' . $item['psd'] . '"' . '
');
        }
        fclose($hd);
    }
    /**
     * @example 404
     */
    public function _empty()
    {
        R('Tool/Tool/show404');
    }
}
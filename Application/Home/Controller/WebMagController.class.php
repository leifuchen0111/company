<?php
/**
 * 自媒体管理
 */
namespace Home\Controller;
use Think\Controller;
class WebMagController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        R('Tool/Tool/checkLogin');

    }
    public function checkTrain(){


        $Ap = M('apMain');
        $Ssid = M('ssid');
        $Website = M('website');
        $WebAp = M('web_ap');


        $gw_id = I('get.gw_id','');
        $mode = $Ap->getFieldByGw_id($gw_id,'mode');
        if($mode == 'AC05' || $mode == 'AC05'){
            $web['ssid'] = $Ssid->getFieldByGw_id($gw_id,'ssid');
            $web['gw_id'] = $gw_id;
            if($WebAp->where($web)->find()){
                $this->error('站点已存在，请勿重复添加!');
            }else{
                $web['webid'] = $Website->getFieldByTpl_style('Train','id');
                $WebAp->data($web)->add();

                $this->success('站点创建成功');
            }

        }
    }
    /**
     * 网站列表
     */
    public function weblist()
    {
        $WebSite = D('website');
        $gw_id = I('get.gw_id','');

        $sql = 'SELECT w.*,a.`ssid`,a.gw_id FROM `rou_website` w LEFT JOIN `rou_web_ap` a ON a.`webid`=w.`id` WHERE a.`gw_id` =\'' . $gw_id . '\'
';
        $websites = $WebSite->query($sql);
        $this->tpls = C('TPL');
        $this->assign('websites', $websites);
        $this->display();
    }


    public function webAdd()
    {

        $this->checkTrain();
        layout(false);
        $Ssid = D('ssid');
        $gw_id = I('get.gw_id','');

        $ssid = $Ssid->getSsidByRid($gw_id);
        if(empty($ssid)){
            $url = U('Ssid/ssidAdd',array('gw_id'=>$gw_id));
            $this->error('请先添加热点',$url);
        }
        $tpl = getTpl();

        $this->assign('ssid',$ssid);
        $this->assign('tpl',$tpl);
        $this->display();

    }
    public function copy()
    {
        if (IS_POST) {
            $webid = I('post.webid', '');
            if(!$webid){
                $this->error('参数ID错误');
            }
            $ap_s = I('post.ssid', '');
            if (!is_array($ap_s)) {
                $this->error('请选择复制对象');
            }
            foreach ($ap_s as $k => $v) {
                $data = explode('_', $v);
                $insert['gw_id'] = $data[0];
                $insert['ssid'] = $data[1];
                if (M('web_ap')->where($insert)->find()) {
                    $this->error($insert['gw_id'] . '-' . $insert['ssid'] . '站点已存在，请先删除');
                }
                $insert['webid'] = $webid;

                $queryId = M('web_ap')->add($insert);
                $data = array(array('api' => 'downTpl', 'webid' => $queryId, 'order' => '100', 'state' => '1'), array('api' => 'getBaseConf', 'webid' => $queryId, 'order' => '95', 'state' => '0'), array('api' => 'getNav', 'webid' => $queryId, 'order' => '90', 'state' => '0'), array('api' => 'getAds', 'webid' => $queryId, 'order' => '85', 'influ_ids' => 'all', 'state' => '1'), array('api' => 'delAds', 'webid' => $queryId, 'order' => '80', 'state' => '0'), array('api' => 'getProducts', 'webid' => $queryId, 'order' => '80', 'influ_ids' => 'all', 'state' => '1'), array('api' => 'delProducts', 'webid' => $queryId, 'order' => '75', 'state' => '0'), array('api' => 'getNews', 'webid' => $queryId, 'order' => '70', 'influ_ids' => 'all', 'state' => '1'), array('api' => 'delNews', 'webid' => $queryId, 'order' => '65', 'state' => '0'), array('api' => 'getApk', 'webid' => $queryId, 'order' => '60', 'influ_ids' => 'all', 'state' => '1'), array('api' => 'delApk', 'webid' => $queryId, 'order' => '55', 'state' => '0'), array('api' => 'getVadio', 'webid' => $queryId, 'order' => '50', 'state' => '0'), array('api' => 'delVadio', 'webid' => $queryId, 'order' => '45', 'state' => '0'), array('api' => 'getMusic', 'webid' => $queryId, 'order' => '40', 'influ_ids' => 'all', 'state' => '1'), array('api' => 'delMusic', 'webid' => $queryId, 'order' => '35', 'state' => '0'), array('api' => 'getBook', 'webid' => $queryId, 'order' => '30', 'influ_ids' => 'all', 'state' => '1'), array('api' => 'delBook', 'webid' => $queryId, 'order' => '25', 'state' => '0'));
                foreach ($data as $item) {
                    M('webapi')->add($item);
                }
            }
            $this->success('操作成功');
        } else {
            $id = I('get.webid', '');
            $ap = M('ap_main')->table(array('rou_ap_main' => 'm'))->field('m.gw_id,s.ssid')->join('rou_ssid s ON s.gw_id=m.gw_id')->where(array('m.uid' => session('userId')))->select();
            $mAp = array();
            foreach ($ap as $v) {
                if (!in_array($v['ssid'], $mAp[$v['gw_id']])) {
                    $mAp[$v['gw_id']][] = $v['ssid'];
                }
            }
            $this->assign('webid', $id);
            $this->assign('ap', $mAp);
            $this->display();
        }
    }


    /**
     * @example 删除站点
     */
    public function delWebsite()
    {
        $Webap = D('webap');
        $Website = D('website');
        $gw_id = I('get.gwId','');
        $id = array('in', I('get.id', ''));
        $map = array();
        $map['webid'] = $id;
        $map['gw_id'] = $gw_id;

        if($Webap->deleteApi($map)) {
            unset($map['gw_id']);
            if(!$Webap->where($map)->find()){

                if(!$Website->websdelete($id)){
                    $array = array('state' => '0', 'msg' => '删除成功');
                    exit(json_encode($array));
                }
            }
        }else{
            $array = array('state' => '0', 'msg' => '删除成功');
            exit(json_encode($array));
        }
        $array = array('state' => '0', 'msg' => '删除成功');
        exit(json_encode($array));
    }

    public function wxinit($appid, $appsecret)
    {
        import('wechat', COMMON_PATH, '.class.php');
        $options = array('token' => 'puyunjishu', 'appid' => $appid, 'appsecret' => $appsecret);
        $weObj = new \Common\Wechat($options);
        return $weObj;
    }

    public function setWx()
    {
        $webid = I('get.webid', '');
        $web = M('website')->field('filename,id')->getByid($webid);
        $gw_id = I('get.gw_id', '');
        $data = array();
        $wx = M('apconf')->field('appid,appsecret')->getByGw_id($gw_id);
        if (empty($wx['appid']) || empty($wx['appsecret'])) {
            $this->error('请现在参数设置中配置微信参数');
        }
        $weObj = $this->wxinit($wx['appid'], $wx['appsecret']);
        $menu['button'] = array(array('type' => 'view', 'name' => '外卖', 'url' => 'http://yun.sun-net.cn' . $web['filename'] . '/index.php?webid=' . $webid));
        $query = $weObj->createMenu($menu);
        $query ? $this->success('设置成功') : $this->error('设置失败');
    }
    /**
     * 检测路由内存状态
     */
    public function checkDev()
    {
        $data = array();
        $data['gw_id'] = I('get.gw_id', '');
        $ApMain = D('ApMain');
        $ap = $ApMain->field('devsize')->where($data)->find();
        $ap = explode('/', $ap['devsize']);
        $size = (double) $ap[1];
        $size < 0.01 ? $this->error('存贮不足！') : true;
    }



    public function webUpload()
    {
        $gwId = I('get.gw_id','');
        $this->checkDev();
        $Ssid = M('Ssid');

        $map['gw_id'] = $gwId;
        $ssid = $Ssid->where($map)->group('ssid')->select();

        $this->assign('ssid',$ssid);
        R('Public/showDetailHeader');
        R('Public/showDetailFooter');
        $this->display();
    }

    public function webSave()
    {
        $webSsid['gw_id'] = I('post.gw_id','');
        $webSsid['ssid'] = I('post.ssid','');
        if(M('web_ap')->where($webSsid)->find()){
            $this->error('该SSID已存在站点，请先删除');
        }

        $config = array(
            'exts' => 'zip',
        );
        $Upload = new \Think\Upload($config);
        $info = $Upload->uploadOne($_FILES['fw']);

        if($Upload->getError()){
            $this->error($Upload->getError());
        }
        if(!$this->saveHtmlWeb($info)){
            unlink('/Uploads/'.$info['savepath'].$info['savename']);
            $this->error('数据写入错误');
        }

        $this->success('上传成功');

    }

    protected function saveHtmlWeb($data){

        $webSsid['gw_id'] = I('post.gw_id','');
        $webSsid['ssid'] = I('post.ssid','');
        $Web = M('website');
        $WebAp = M('web_ap');
        $WebApi = M('webapi');

        $web['filename'] = '/Uploads/'.$data['savepath'].$data['savename'];
        $web['tpl_style'] = substr($data['name'],0,-4);
        if(!$Web->add($web)) {
            return false;
        }

        $webSsid['webid'] = $Web->getLastInsID();

        if(!$WebAp->data($webSsid)->add()){
            return false;
        }
        $webapi['webid'] = $WebAp->getLastInsID();
        $webapi['api'] = 'downTpl';
        $webapi['state'] = '1';
        $webapi['order'] = '100';
        if(!$WebApi->add($webapi)){
            return false;
        }
        return true;
    }

    public function _empty()
    {
        R('Tool/Tool/show404');
    }
}
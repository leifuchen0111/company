<?php
/**
 * ssid
 *
 */
namespace Home\Controller;

use Think\Controller;
class SsidController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        R('Tool/Tool/checkLogin');
    }

    public function ssidList()
    {
        $Ssid = D('ssid');
        $gw_id = I('get.gw_id', '');
        $map = array();

        $map['gw_id'] = $gw_id;
        $ssid = $Ssid->where($map)->select();
        $xChannel = $Ssid->getChannel($gw_id);

        $this->assign('ssid', $ssid);
        $this->assign('xChannel', $xChannel);
        $this->display();
    }

    public function ssidEdit()
    {

    }

    public function ssidSave()
    {
        $Ssid = D('ssid');
        if (IS_POST) {
            $data = $Ssid->create();
            if(!$data){
                $this->error($Ssid->getError());
            }
            if($Ssid->id){
                if($Ssid->save()){
                    $this->success('修改成功，请记得推送', U('ssidList', array('gw_id' => I('post.gw_id', ''))));
                }else{
                    $this->error('修改失败');
                }
            }else{
                if(!$Ssid->add()){
                    $this->error('添加失败');
                }else{

                    $this->success('添加成功，请记得推送', U('ssidList', array('gw_id' => I('post.gw_id', ''))));
                }
            }
        }
    }

    public function ssidAdd()
    {

        R('Public/showDetailHeader');
        R('Public/showDetailFooter');
        $this->display();

    }
    /**
     * @example 推送
     *
     */
    public function appSsid()
    {
        $gwId = I('get.gw_id', '');

        setSsdiConfFile($gwId);
        getSsid($gwId);
        $this->success('操作执行中，请等待2-3分钟查看');

    }
    /**
     * @example 删除ssid
     */
    public function delSsids()
    {
        if (IS_AJAX) {
            $Ssid = D('ssid');
            $WebAp = D('webap');
            $Website = D('website');
            $Api = D('webapi');
            $id = I('get.id');

            //获取gw和ssid
            $gw_ssid = $Ssid->getGwId($id);

            //删除web_ap表数据
            $webId = $WebAp->webApdelete($gw_ssid);

            $map = array();
            $map['id'] = array('in',$id);
            $result3 = $Ssid->where($map)->delete();

            //生成配置文件
            if($result3){
                foreach($gw_ssid[0] as $k=>$v){
                    setSsdiConfFile($k);
                    getSsid($k);
                }
                echo json_encode(array('state' => 0, 'msg' => '删除成功'));
            }else {
                echo json_encode(array('state' => 1, 'msg' => '删除失败!!'));
            }
        }
    }
    //修改频段
    public function xchannel()
    {
        $data['2c'] = I('post.2c', '');
        $data['5c'] = I('post.5c', '');
        $where['gw_id'] = array('in', I('post.gw_id', ''));
        $gw_id = explode(',', I('post.gw_id', ''));
        $count = count($gw_id);
        if (M('apconf')->where($where)->data($data)->save()) {
            for ($i = 0; $i < $count; $i++) {
                setSsdiConfFile($gw_id[$i]);
            }
            $this->success('修改成功', U('ssidList', array('gw_id' => I('post.gw_id', ''))));
        } else {
            echo M('apconf')->getLastSql();
            $this->error('修改失败');
        }
    }

    public function _empty()
    {
        R('Tool/Tool/show404');
    }
}

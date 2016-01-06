<?php
namespace Home\Controller;

use Think\Controller;
class TableAjaxController extends Controller
{
    /**
     * 所有AP30天内认证用户走势图
     */
    public function allApVisitor_30()
    {
        if (IS_AJAX) {
            $Public = A('Public');
            $aps = $Public->treeAp(session('userId'));
            $ap_id = array();
            foreach ($aps as $item) {
                $ap_id[] = $item['id'];
            }
            $Mac = D('Mac');
            $data['rid'] = array('in', implode(',', $ap_id));
            //   $data['stime'] = array('between',array(strtotime(date('Y-m-d',time()))-30*24*3600,strtotime(date('Y-m-d',time()))));
            //    $mac = $Mac->where($data)->select();
            //    var_dump($mac);
            $arr = array();
            $len = 30;
            for ($i = $len; $i > 0; $i--) {
                $data['stime'] = array('between', array(strtotime(date('Y-m-d', time())) - $i * 24 * 3600, strtotime(date('Y-m-d', time())) - ($i - 1) * 24 * 3600));
                $arr['mac'][] = (int) $Mac->where($data)->count();
                $arr['time'][] = $i;
            }
            //var_dump($arr);die;
            echo json_encode($arr);
        }
    }
    /**
     * 单AP12小时内人流走势图
     */
    public function macScan()
    {
        $gw_id = I('get.gwid', '');
        $MacScan = D('Macscan');
        $data['gw_id'] = $gw_id;
        $len = 24;
        for ($i = $len; $i > 0; $i--) {
            $data['updtime'] = array('between', array(time() - $i * 3600, time() - ($i - 1) * 3600));
            $arr['mac'][] = (int) $MacScan->where($data)->count();
            $arr['time'][] = $i;
        }
        echo json_encode($arr);
    }
    public function _empty()
    {
        R('Tool/Tool/show404');
    }
}
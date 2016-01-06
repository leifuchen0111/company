<?php
namespace Home\Controller;

use Think\Controller;
class MacController extends BaseController
{
    private $Public;
    public function __construct()
    {
        parent::__construct();
        R('Tool/Tool/checkLogin');
        if (isset($_GET['id']) && !empty($_GET['rid'])) {
            $this->Public->haveJsd(I('get.id', ''));
        }
    }
    /**
     * mac 白名单列表
     *
     */
    public function macWhite()
    {
        $Public = A('Public');
        $rid = I('get.id', '');
        $Macwblist = D('Macwblist');
        $maclist = $Macwblist->scope('white')->where(array('rid=' . $rid))->select();
        $this->assign('maclist', $maclist);
        $Public->showDetailHeader();
        $this->display('Mac/macList');
        $Public->showDetailfooter();
    }
    /**
     * mac 黑名单列表
     */
    public function macBlack()
    {
        $Public = A('Public');
        $rid = I('get.id', '');
        $Macwblist = D('Macwblist');
        $maclist = $Macwblist->scope('black')->where(array('rid=' . $rid))->select();
        $this->assign('maclist', $maclist);
        $Public->showDetailHeader();
        $this->display('Mac/macList');
        $Public->showDetailfooter();
    }
    /**
     * mac 扫描列表
     */
    public function macScan()
    {
        $Public = A('Public');
        $gw_id = I('get.gw_id', '');
        $Macwblist = D('Macscan');
        $maclist = $Macwblist->where(array('gw_id' => $gw_id))->group('mac')->select();
        $this->assign('maclist', $maclist);
        $Public->showDetailHeader();
        $this->display('Mac/macScan');
        $Public->showDetailfooter();
    }
    /**
     * mac 在线列表
     */
    public function macOnline()
    {

        $id = I('get.id','');
        $Mac = D('Mac');

        $maclist = $Mac->getOnlineByOne($id);



        $this->assign('maclist', $maclist);
        $this->display('Mac/macOnline');

    }
    /**
     * 在线mac强制下线
     */
    public function offLine()
    {
        if (IS_AJAX) {
            $Mac = D('Mac');
            $data['id'] = array('in', I('post.id', ''));
            $setting['status'] = '0';
            $query = $Mac->where($data)->data($setting)->save();
            if ($query) {
                echo json_encode(array('state' => 0, 'msg' => '操作成功'));
            } else {
                echo json_encode(array('state' => 1, 'msg' => '可能改路由已经下线，操作失败'));
            }
        }
    }
    /**
     * mac 历史列表
     */
    public function macHistory()
    {
        $Public = A('Public');
        $rid = I('get.id', '');
        $Macwblist = D('Mac');
        $maclist = $Macwblist->relation('bw')->scope('history')->where(array('rid=' . $rid))->select();
        $this->assign('maclist', $maclist);
        $Public->showDetailHeader();
        $this->display('Mac/macOnline');
        $Public->showDetailfooter();
    }
    /**
     * mac扫描 mac 生成图表
     */
    public function macScanDetails()
    {
        $Mac = D('Macscan');
        $mac = I('get.mac', '');
        $detail = $Mac->field('xh,updtime')->where(array('mac' => $mac))->select();
        $time = array();
        $sh = array();
        foreach ($detail as $item) {
            array_push($time, date('H:i:s', $item['updtime']));
            array_push($sh, $item['xh']);
        }
        $chart = new \Org\Util\Chart();
        $title = $mac . '的信号强度反向图';
        //标题
        $data = $sh;
        //数据
        $size = 140;
        //尺寸
        $width = 800;
        //宽度
        $height = 350;
        //高度
        $legend = $time;
        //说明
        $chart->createmonthline($title, $data, $size, $height, $width, $legend);
    }
    /**
     * 删除MAC白名单
     */
    public function delWhite()
    {
        $id = I('get.id', '');
        $result = M('macwblist')->where(array('id' => $id))->delete();
        if ($result) {
            $this->ajaxReturn(array('state' => 0, 'msg' => '删除成功'));
        } else {
            $this->ajaxReturn(array('state' => 1, 'msg' => '删除成功'));
        }
    }
    /**
     * mac 扫描详情
     */
    public function macScanDetail()
    {
        $Public = A('Public');
        $mac = I('get.mac', '');
        $this->assign('mac', $mac);
        $Public->showDetailHeader();
        $this->display('Tongji/macScan');
        $Public->showDetailFooter();
    }
    /**
     * mac 导出
     */
    public function macExport()
    {
        $Public = A('Public');
        $type = I('get.type', '');
        switch ($type) {
            case 'macscan':
                $headArr = array('id', 'mac', '信号强度', '扫描时间');
                $Mac = M('macscan');
                $data = array();
                $dataWhere['gw_id'] = I('get.gw_id', '');
                $data = $Mac->field('id,mac,xh,updtime')->where($dataWhere)->select();
                $objExcel = new \Org\Util\PHPExcel();
                $i = 0;
                //表头
                $k1 = 'ID';
                $k2 = 'mac';
                $k3 = '信号强度';
                $k4 = '扫描时间';
                $objExcel->getActiveSheet()->setCellValue('a1', "{$k1}");
                $objExcel->getActiveSheet()->setCellValue('b1', "{$k2}");
                $objExcel->getActiveSheet()->setCellValue('c1', "{$k3}");
                $objExcel->getActiveSheet()->setCellValue('d1', "{$k4}");
                //debug($links_list);
                foreach ($data as $k => $v) {
                    $u1 = $i + 2;
                    /*----------写入内容-------------*/
                    $objExcel->getActiveSheet()->setCellValue('a' . $u1, $v['id']);
                    $objExcel->getActiveSheet()->setCellValue('b' . $u1, $v['mac']);
                    $objExcel->getActiveSheet()->setCellValue('c' . $u1, $v['xh']);
                    $objExcel->getActiveSheet()->setCellValue('d' . $u1, date('Y//m/d H:i:s', $v['updtime']));
                    $i++;
                }
                // 高置列的宽度
                $objExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
                $objExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
                $objExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
                $objExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
                $objExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BPersonal cash register&RPrinted on &D');
                $objExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objExcel->getProperties()->getTitle() . '&RPage &P of &N');
                // 设置页方向和规模
                $objExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
                $objExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                $objExcel->setActiveSheetIndex(0);
                $timestamp = time();
                if ($ex == '2007') {
                    //导出excel2007文档
                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment;filename="' . $dataWhere['gw_id'] . '_' . date('Y_m_d-H_i_s', time()) . '.xlsx"');
                    header('Cache-Control: max-age=0');
                    $objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');
                    $objWriter->save('php://output');
                    die;
                } else {
                    //导出excel2003文档
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment;filename="' . $dataWhere['gw_id'] . '_' . date('Y_m_d-H_i_s', time()) . '.xls"');
                    header('Cache-Control: max-age=0');
                    $objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel5');
                    $objWriter->save('php://output');
                    die;
                }
                break;
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
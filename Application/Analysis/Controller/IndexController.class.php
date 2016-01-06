<?php
/**
 * Created by PhpStorm.
 * User: lfc
 * Date: 2015/12/21
 * Time: 9:37
 */

namespace Analysis\Controller;


class IndexController extends BaseController
{


    public function index()
    {
        $Pv = D('carsPv');

        $Down = D('carsDown');

        $data = array();
        $data['pv'] = $Pv->count();
        $data['down'] = $Down->count();

        $todayPv = $Pv->getToday();
        $todayDwon = $Down->getToday();

        $sevenPv =  $Pv->getSeven();
        $sevenDown =  $Down->getSeven();


        $this->todayPv = $todayPv;
        $this->todayDown = $todayDwon;
        $this->sevenPv = $sevenPv;
        $this->sevenDown = $sevenDown;

        $this->data = $data;
        $this->display();
    }

    public function sevenDays()
    {

        $Pv = D('carsPv');

        $data = $Pv->getSeven();
    }


    public function import()
    {

        set_time_limit(0);
        ignore_user_abort();


        $ApMain = M('apMain');
        $Pv = M('cars_pv');
        $Down = M('cars_down');
        $Mac = M('mac');

        for($i=0;$i<10000;$i++) {


            $rid = rand(47, 100);
            $pageid = rand(0, 4);

            $pageArr = array(

                '/content/?#register',
                '/content/?#cash',
                '/content/down.html',
                '/conRank/?icode=CCP6VV4&from=singlemessage&isappinstalled'

            );

            $data['page'] = $pageArr[$pageid];
            $data['gw'] = $ApMain->getFieldById($rid, 'gw_id');

            if (!$data['gw']) continue;

            $data['createtime'] = intval(rand(1448073167,1450665167));
            $Pv->data($data)->add();

            if(rand(1,10)<=2) continue;

            $down = array();
            $typeR = array('a','i');
            $phoneR = array('13','15','18','14');
            $macId = rand(75500,76700);

            $down['mac'] = $Mac->getFieldById($macId,'mac');

            if(!$down['mac']) continue;

            $down['type'] = $typeR[rand(0,1.99)];
            $down['phone'] = $phoneR[rand(0,3)].rand(100000000,999999999);
            $down['createtime'] = $time = rand(1448073167,1450665167);
            $down['gw'] = $data['gw'];

            $Down->data($down)->add();

        }

    }

}
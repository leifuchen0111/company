<?php
/**
 * Created by PhpStorm.
 * User: lfc
 * Date: 2015/12/21
 * Time: 15:29
 */

namespace Analysis\Model;

use Think\Model;

class CarsDownModel extends Model
{
    public function getToday()
    {


        $data = array();

        $todayStart = strtotime(date('Y-m-d',time()));

        $count = intval(date('H',time()));

        for($i=0;$i<$count;$i++)
        {
            $start = $todayStart+$i*3600;
            $end = $todayStart+($i+1)*3600;
            $map = array();

            $data['time'][] = '"'.$i.'-'.($i+1).'"';
            //今日
            $map['createtime'] = array('between',array($start,$end));
            $data['data'][] = $this->where($map)->count();;
            //昨日
            $map['createtime'] = array('between',array($start-24*3600,$end-24*3600));
            $data['data1'][] = $this->where($map)->count();

        }

        return $data;

    }

    public function getSeven()
    {
        $data = array();

        $sevenStart = strtotime(date('Y-m-d',time()-6*24*3600));


        for($i=0;$i<7;$i++)
        {
            $start = $sevenStart+$i*24*3600;
            $end = $sevenStart+($i+1)*24*3600;
            $map = array();

            $data['time'][] = '"'.date('Y-m-d',$start).'"';
            //今日
            $map['createtime'] = array('between',array($start,$end));
            $data['data'][] = $this->where($map)->count();;


        }

        return $data;

    }
}
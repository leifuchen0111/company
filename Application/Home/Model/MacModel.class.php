<?php 
namespace Home\Model;
use Think\Model;
class MacModel extends Model{

    public function getMacList($ap,$Page,$start){
        if(is_array($ap)) {
            $apid = array();
            foreach ($ap as $item) {
                $apid[] = $item['id'];
            }
            $map['rid'] = array('in', implode(',', $apid));
        }else{
            $map['rid'] = $ap;
        }
        $map['ltime'] = array('neq','');
        $map['stime'] = array('gt',$start);
        if($Page){
            $limit = $Page->firstRow.','.$Page->listRows;
        }
        $maclist = $this->where($map)->limit($limit)->select();

        return $maclist;
    }

    //获取单个路由的在线人数
    public function getOnlineCountByOne($id)
    {
        if(empty($id))
        {
            return 0;
        }
        $map['rid'] = $id;
        $map['status'] = 1;
        return $this->where($map)->count();
    }

    public function getOnlineByOne($id,$page = ''){

        if(empty($id))
        {
            return 0;
        }
        $map['rid'] = $id;
        $map['status'] = 1;

        if($page){
            $rows = $page->firstRow.','.$page->listRows;
        }

        return $this->where($map)->limit($rows)->select();

    }

    public function getMacCount($ap,$start){
        $apid = array();
        foreach($ap as $item){
            $apid[] = $item['id'];
        }
        $map['rid'] = array('in',implode(',',$apid));
        $map['ltime'] = array('neq','');
        if($start) $map['stime'] = array('gt',$start);
        return  M('mac')->where($map)->count();
    }

}
?>
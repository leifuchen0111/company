<?php 
namespace Tool\Controller;
use Think\Controller;
class CrontabController extends Controller{
    /*定时重启路由*/
    public function index(){
        M('ap_main')->where(1)->save(array('torestart'=>'1'));
    }
    /*定时导出扫描MAC*/
    public function exportMac(){
        $where = array();
        $arr = array();
        $filename = date('Y_m_d',time());
        while($gw_id = M('macscan')->field('gw_id')->where($where)->find()){
            $arr[] = $gw_id['gw_id'];
            $where['gw_id'] = array('notin',implode(',',$arr));
            $expDat = M('macscan')->where(array('gw_id'=> $gw_id['gw_id']))->select();
            M('macscan')->where(array('gw_id'=>$gw_id['gw_id']))->delete();
            $export = serialize($expDat);
            if(!is_dir(WEB_ROOT.'/RouteConf_File/'.$gw_id['gw_id'])) mkdir(WEB_ROOT.'/RouteConf_File/'.$gw_id['gw_id'],0777,'r');
            $hd = fopen(WEB_ROOT.'/RouteConf_File/'.$gw_id['gw_id'].'/'.$filename,'w');
            fwrite($hd,$export);
            fclose($hd);
        }
        $sql = 'truncate table rou_macscan';
        M()->query($sql);
    }
}
?>
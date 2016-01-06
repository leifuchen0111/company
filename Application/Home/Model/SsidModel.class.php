<?php 
/**
 * ssid 模型
 */
namespace Home\Model;
use Think\Model;
class SsidModel extends Model{
   protected $_validate = array(
        array('ssid','_isExsist','SSID已经存在',1,'callback'),
    );

    public function getSsidByRid($gw_id)
    {
        $map['gw_id'] = $gw_id;
        return $this->where($map)->select();
    }

    public function getChannel($gwId)
    {
        $fields = '2c,5c';
        $data = M('apconf')->field($fields)->getByGw_id($gwId);

        return $data;

    }

    public function _isExsist()
    {
        $map['ssid'] = I('post.ssid','');
        $map['gw_id'] = I('post.gw_id','');
        $map['channel'] = I('post.channel','');
        $query = $this->where($map)->find();

        return $query?false:true;
    }

    public function getGwId($id){

        $map['id'] = array('in',$id);
        $ssid = $this->where($map)->select();
        $gw_ssid = array();
        foreach($ssid as $v){
            $gw_ssid[] = array(
                $v['gw_id'] => $v['ssid']
            );
        }
        return $gw_ssid;
    }
}
?>

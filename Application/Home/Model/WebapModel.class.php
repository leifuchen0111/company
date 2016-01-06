<?php 
namespace Home\Model;
use Think\Model;
class WebapModel extends Model{
   protected $tableName = 'web_ap';

    public function webApdelete($gw_ssid)
    {
        foreach($gw_ssid as $k=>$v){
            foreach($v as $gw=>$ssid) {
                $map = array();
                $map['gw_id'] = $gw;
                $map['ssid'] = $ssid;
                $data[] = $this->deleteApi($map);
            }
        }

        $webid = array();
        $api_webid = array();
        foreach($data as $v){
            $webid[] = $v['webid'];
            $api_webid[] = $v['id'];
        }

        $return = array(
            'webid' => implode(',',$webid),
            'api_webid' => implode(',',$api_webid)
        );

        return $return;
    }

    protected function deleteOne($map){

        $fields = 'id,webid';
        $data = $this->field($fields)->where($map)->find();
        $this->where($map)->delete();
        return $data;
    }

    public function deleteApi($map)
    {
        $data = $this->where($map)->find();
        $result = $this->delete($data['id']);

        $map = array();
        $map['webid'] = $data['id'];
        //删除接口提示数据
        M('webapi')->where($map)->delete();

        $map = array();
        $map['webid'] = $data['webid'];
        if(!$this->where($map)->find()){
            //无SSID指向该站点，删除之
            D('website')->websdelete($map['webid']);
        }

        if($result){
            return true;
        }else{
            return false;
        }
    }
}
?>
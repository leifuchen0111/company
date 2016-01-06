<?php 
namespace Home\Model;
use Think\Model;
class ApconfModel extends Model{
    protected $_auto = array(
        array('isrecord','isRecord',2,'callback')
    );

    public function isRecord(){
        $record = I('post.isrecord','');
        if($record == 0){
            return  '';
        }else{
            return json_encode(I('post.recordType', ''));
        }
    }

    public function getOne($gwId){

        $data = $this->getByGw_id($gwId);

        if (!$data) {
            $data['gw_id'] = $gwId;
            $this->data($data)->add();
        }
        return $data;
    }
    
    
}
?>
<?php 
namespace Home\Model;
use Think\Model;
class ApMainModel extends Model{

    public function getApCount($userList,$key=''){

        $usersID = array();
        $userid_name = array();
        foreach($userList as $item){
            $usersID[] = $item['id'];
            $userid_name[$item['id']] = $item['name'];
        }
        $usersID[] = session('userId');
        if(C('SUPER_ADMIN_ID') != session('userId')){
            $where = array();
            $where['uid'] = array('in',implode(',',$usersID));
        }

        if(!empty($key)){

            $where['hwserial'] = array('like','%'.$key.'%');
            $where['uid'] = M('user')->getFieldByName($key,'id');
            $where['_logic'] = 'or';
        }
        $count = $this->where($where)->count();

        return $count;


    }
    public function getApList($userList,$Page='',$key = ''){

        $where = array();
        $usersID = array();
        $userid_name = array();
        foreach($userList as $item){
            $usersID[] = $item['id'];
            $userid_name[$item['id']] = $item['name'];
        }
        $usersID[] = session('userId');
        if(C('SUPER_ADMIN_ID') != session('userId')){
            $where = array();
            $where['p.uid'] = array('in',implode(',',$usersID));

        }

        if(!empty($key)){

            $where['p.hwserial'] = array('like','%'.$key.'%');
            $where['p.uid'] = M('user')->getFieldByName($key,'id');
            $where['_logic'] = 'or';
        }

        if($Page){
            $limit = $Page->firstRow.','.$Page->listRows;
        }
        $data = $this->alias('p')->field('a.onUser,a.lastip,p.uid,p.id,p.fw,p.hwserial,a.lasttime')
            ->join('left join '. C('DB_PREFIX').'apnow a ON a.gw_id=p.gw_id')
            ->where($where)
            ->order('a.lasttime desc')
            ->limit($limit)
            ->select();

        foreach($data as &$value){
            $value['user'] = $userid_name[$value['uid']];
        }
        return $data;
    }

    //需要添加路由操作权限检测
    public function distribute($id,$user){

        $map['id'] = array('in',$id);
        $uid = M('user')->getFieldByName($user,'id');
        $data['uid'] = $uid;

        if($this->where($map)->save($data)){
            return true;
        }else{
            return false;
        }



    }

}
?>
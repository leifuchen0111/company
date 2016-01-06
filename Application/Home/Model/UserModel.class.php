<?php
namespace Home\Model;
use Think\Model;
class UserModel extends Model{
    /**
     * 字段映射
     * formField => TabField
     * 
     */
    protected $_map = array(
        'pass' => 'pwd',
        'username' => 'name',
        'contact_phone' => 'phone',
        ''
    );
    /**
     * 自动验证
     * array(验证字段,验证规则,提示信息,验证条件,附加规则,验证时)
     */
    protected $_validate = array(
        array('name','require','用户名不能为空'),
        array('pass','require','密码不能为空',0),
        array('repass','pwd','两次输入密码不一致',0,'confirm'),
        array('email','email','邮箱格式不对',2),
        array('phone','/^1[3|4|5|8|7][0-9]{9}$/','手机号格式不对',2,'regex'),
       
    );
    /**
     * 自动完成
     * @var unknown
     */
    protected $_auto = array(
        array('pwd','dealPass',2,'ignore'),
        array('pwd','dealPass',Model::MODEL_BOTH,'callback'),
        array('lastip','get_client_ip',Model::MODEL_UPDATE,'function'),
        array('lasttime','time',Model::MODEL_UPDATE,'function')
    );
    
    protected function dealPass(){

        return substr(md5(I('post.pass','')),1,30);

    }

    public function getUserList($id=''){
		if(!$id)
		{
			$id = session('userId');
		}
       /* $arr = array();
        $arr = F(session('name').'/member');*/
        if(empty($arr) || !$arr){
            if($id == C('SUPER_ADMIN_ID')){
                $arr = $this->where(array('id'=>array('neq',C('SUPER_ADMIN_ID'))))->field('id,name,role_id,lasttime,lastip')->select();
            }else{
                static $tree = array();
                $data = $this->where(array('pid'=>$id))->field('id,name')->select();
                !in_array($data,$tree)?$tree[] = $data:'';
                if($data){
                    foreach($data as $item){
                        if(!is_array($item)){
                            continue;
                        }else{
                            $this->getUserList($item['id']);
                        }
                    }
                }
                $arr = array();
                foreach($tree as $item){
                    if(!$item) continue;
                    foreach($item as $v){
                        $arr[] = $v;
                    }
                }
            }
           // F(session('name').'/member',$arr);
        }
        return $arr;

    }

    public function getMemberCount($pid){
        if($pid)
        {
            $map['pid'] = intval($pid);
        }
        return $this->where($map)->count();
    }

    public function getMemberList($Page,$pid){
        if($Page)
        {
            $rows = $Page->firstRow.','.$Page->listRows;
        }
        if($pid)
        {
            $map['pid'] = $pid;
        }
        $member = $this->where($map)->limit($rows)->select();
        foreach($member as &$value)
        {
            $value['chcount'] = $this->getMemberCount($value['id']);
        }

        return $member;
    }
}
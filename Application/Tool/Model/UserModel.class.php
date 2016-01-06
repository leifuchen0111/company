<?php
namespace Tool\Model;
use Think\Model;
class UserModel extends Model{
    /**
     * 字段映射
     * formField => TabField
     * 
     */
    protected $_map = array(
        'password' => 'pwd',
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
        array('pwd','require','密码不能为空'),
        array('repassword','pwd','两次输入密码不一致',Model::EXISTS_VALIDATE,'confirm'),
        array('email','email','邮箱格式不对',Model::EXISTS_VALIDATE),
        array('phone','/^1[3|4|5|8][0-9]{9}$/','手机号格式不对',Model::EXISTS_VALIDATE,'regex',Model::MODEL_BOTH),
       
    );
    /**
     * 自动完成
     * @var unknown
     */
    protected $_auto = array(
        array('pwd','dealPass',Model::MODEL_BOTH,'callback'),
        array('lastip','get_client_ip',Model::MODEL_UPDATE,'function'),
        array('lasttime','time',Model::MODEL_UPDATE,'function')
    );

    protected function dealPass(){
        if(I('post.pwd'))
        return substr(md5(I('post.pwd','')),1,30);
    }
}
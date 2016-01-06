<?php
namespace Mmclick\Controller;
use Think\Controller;
class IndexController extends Controller{

    public function __construct(){

        parent::__construct();
        R('Home/Public/showHeader');
        R('Home/Public/showFooter');
    }

    public function index(){

        $Image = M('mmclick');
        $image = $Image->field('image')->order('id desc')->find();
        echo 'http://yun.sun-net.cn/Uploads/mmclick/'.$image['image'];exit;

    }

    public function add(){

        $this->display();
    }

    public function save(){

        $Mmclick = M('mmclick');

        $config = array(
            'exts' => 'jpg,png',
            'rootPath' => './Uploads/mmclick/'
        );

        $Upload = new \Think\Upload($config);
        $info = $Upload->uploadOne($_FILES['image']);

        if($Upload->getError()){
            $this->error($Upload->getError());
        }

        $data = array(
            'image' => $info['savepath'].$info['savename'],
            'create_time' => time()
        );

        $result  = $Mmclick->add($data);

        if($result){
            $this->success('修改成功');
        }else{
            $this->error('修改失败');
        }
    }

}
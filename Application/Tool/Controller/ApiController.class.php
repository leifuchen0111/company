<?php
namespace Tool\Controller;
use Think\Controller;
class ApiController extends Controller{

    public function getData(){

        

    }


    /**
     * @example 验证码
     */
    public function verify(){
        $Img = new \Org\Util\Image;
        $Img->buildImageVerify(4,1,'png',100,50);
    }

    public function download(){
        header("Content-type:text/html;charset=utf-8");
        $file_name= I('get.name','');
        //中文兼容
        $file_name=iconv("utf-8","gb2312",$file_name);
        //获取网站根目录，这里可以换成你的下载目录
        $file_sub_path=WEB_ROOT.'/FwDownload/';
        $file_path=$file_sub_path.$file_name;
        //判断文件是否存在
        if(!file_exists($file_path)){
            echo '文件不存在';
            return ;
        }
        $fp=fopen($file_path,"r");
        $file_size=filesize($file_path);
        //下载文件所需的header申明
        Header("Content-type: application/octet-stream");
        Header("Accept-Ranges: bytes");
        Header("Accept-Length:".$file_size);
        Header("Content-Disposition: attachment; filename=".$file_name);
        $buffer=1024;
        $file_count=0;
        //返回数据到浏览器
        while(!feof($fp) && $file_count<($file_size-1)){
            $file_con=fread($fp,$buffer);
            $file_count+=$buffer;
            echo $file_con;
        }
        fclose($fp);
        exit();
    }

    public function getTjData()
    {

        if(!$this->checkAuth())
        {
            die('token error');
        }
        $map['date'] = date('Ymd');
        $data = I('post.date','');
        if(isset($_POST['date']) && !empty($data))
        {
            $map['date'] = I('post.date','');
        }
        $gw_id = I('post.gwid','');
        if(isset($_POST['gwid']) && !empty($gw_id))
        {
            $map['gwid'] = I('post.gwid','');
        }

        $query = M('tj_train')->where($map)->select();

        echo json_encode($query);exit;

    }

    protected function checkAuth()
    {
        $ftoken = I('post.token','');
        $token = '465asd4da3e5v3sd4fge5rj1uik4g55u';
        if($ftoken != $token)
        {
            return false;
        }
        return true;
    }

}
?>
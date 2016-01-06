<?php
namespace Android\Controller;
use Think\Controller;
class UpgradeController extends Controller{
    
    private $Android;
    
    public function __construct(){
        
        parent::__construct();
        $this->Android = M('android');
    }
    
/**
     * 固件检测并更新
     */
    public function ApkCheckUpd(){
        
        $type = I('get.mode','');
        if(empty($type)){
            
            die('param error');
        }
        $apk = $this->Android->where(array('type'=>array('like','%'.$type.'%')))->field('version,time,desc')->order('`time` desc')->find();
        echo json_encode($apk);
        
    }
    public function Apkdownload(){
        $type = I('get.mode','');
        if(empty($type)){
            die('param error');
        }
        $apk = $this->Android->where(array('type'=>array('like','%'.$type.'%')))->field('filename,id,downcount')->order('`time` desc')->find();
        $data = array();
        $data['id'] = $apk['id'];
        $data['downcount'] = $apk['download']+1;
        $this->Android->data($data)->save();
        $this->downFile(WEB_ROOT.'/Public/Apkdownload/',$apk['filename']);
        exit();
    }
    
    
    
    protected function downFile($path,$file_name){
    
        header("Content-type:text/html;charset=utf-8");
        // echo $path,$file_name;
    
        //中文兼容
        $file_name=iconv("utf-8","gb2312",$file_name);
        //获取网站根目录，这里可以换成你的下载目录
        $file_sub_path=$path;
         
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
        while(!feof($fp) && $file_count<$file_size){
            $file_con=fread($fp,$buffer);
            $file_count+=$buffer;
            echo $file_con;
        }
        fclose($fp);
    
    
    }
    
}

?>
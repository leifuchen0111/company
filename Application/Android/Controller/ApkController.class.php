<?php 
namespace Android\Controller;
use Home\Controller\BaseController;

class ApkController extends BaseController{
    private $Android;
    public function __construct(){
        
        parent::__construct();
        if(session('userId') != 1){
            
           R('Tool/Tool/show404');
        }
        $this->Android = M('android');
    }
    
    public function ApkHistory(){
        
        $apk = $this->Android->order('`time` desc')->select();
        $this->assign('fw',$apk);

        $this->display('Fw/androidList');
        
    }
    /**
     * 固件上传
     */
    public function ApkUpload(){
        
        if(IS_POST){
            $arr = explode('_', $_FILES['fw']['name']);

            $data['version'] = I('post.version','');
            $data['filename'] = $_FILES['fw']['name'];
            $data['desc'] = I('post.desc','');
            $data['time'] = time();
            $data['type'] = implode(I('post.mode','a'));

            move_uploaded_file($_FILES['fw']['tmp_name'], WEB_ROOT.'/Public/Apkdownload/'.$_FILES['fw']['name']) or die('文件移动失败');

            if($this->Android->data($data)->add()){
                
                $this->success('上传成功',U('Apk/ApkHistory'));
            }else{
                
                echo $this->Android->getLastSql();die;
                unlink(SERVER_ROOT.'/download/'.$data['file_name']);
                $this->error('上传失败');
            }
            
        }else{

            $this->display('Fw/androidEdit');
        }
        
    }
    
    
    
    /**
     * 404
     */
    public function _empty(){
        R('Tool/Tool/show404');
    }
    
}
?>
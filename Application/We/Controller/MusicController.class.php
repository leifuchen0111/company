<?php 
namespace We\Controller;
use Think\Controller;
class MusicController extends Controller{
    public function __construct(){
        parent::__construct();
        $Public = new PublicController();
        $Public->checkLogin();
    }
    public function musicList(){
        $vadio = M('music')->where(array('webid'=>I('get.webid','')))->select();
        $this->assign('vadio',$vadio);
        R('Public/showHeader');
        $this->display('MusicList');
        R('Public/showFooter');
    }
    public function musicAdd(){
        if(IS_POST){
            if($_FILES['img']['size']>2*1024*1024) $this->error('缩略图过大');
            switch ($_FILES['img']['type']){
                case 'image/jpeg':
                    $str = '.jpg';
                    break;
                case 'image/gif':
                    $str = '.gif';
                    break;
                case 'image/png':
                    $str = '.png';
                    break;
                default:
                    $this->error('缩略图格式错误!');
                    break;
            }
            $web = M('website')->find(I('post.webid',''));
            $name = uniqid();
            if(!is_dir(WEB_ROOT.$web['filename'].'/reource/')) mkdir(WEB_ROOT.$web['filename'].'/reource/',0777,true);
            move_uploaded_file($_FILES['img']['tmp_name'], WEB_ROOT.$web['filename'].'/reource/'.$name.$str) or $this->error('文件上传失败');
            move_uploaded_file($_FILES['apk']['tmp_name'], WEB_ROOT.$web['filename'].'/reource/'.$name.'.mp3') or $this->error('文件上传失败');
            $data = array();
            $data['webid'] = I('post.webid','');
            $data['name'] = I('post.name','');
            $data['author'] = I('post.author','');
            $data['posttime'] = time();
            $data['album'] = I('post.album','');
            $data['img'] = $web['filename'].'/reource/'.$name.$str;
            $data['url'] = $web['filename'].'/reource/'.$name.'.mp3';
            $query = M('music')->data($data)->add();
            unset($data);
            $api_web = M('web_ap')->where(array('webid'=>I('post.webid','')))->field('id')->select();
            foreach($api_web as $v){
                $api = M('webapi')->where(array('webid'=>$v['id'],'api'=>'getMusic'))->field('influ_ids,id')->find();
                $data = array();
                $data['state'] = '1';
                $data['influ_ids'] = $api['influ_ids']?$api['influ_ids'].','.$query:$query;
                $data['influ_ids'] = implode(',', array_unique(explode(',', $data['influ_ids'])));
                $data['id'] = $api['id'];
                M('webapi')->data($data)->save();
            }
            $query?$this->success('上传成功!',U('musicList',array('webid'=>I('post.webid','')))):$this->error('文件上传失败!');
        }else{
            $cate = M('category')->where(array('webid'=>I('get.webid',''),'type'=>'music'))->select();
            $this->assign('cate',$cate);
            R('Public/showHeader');
            $this->display('MusicAdd');
            R('Public/showFooter');
        }
    }
    
    public function musicDel(){
        if(IS_AJAX){
            
            if(!I('get.id','')){
                echo json_encode(array('state'=>1,'msg'=>'参数错误'));exit();
            }
            $data['id'] = array('in',I('get.id',''));
            $web = M('music')->where($data)->field('img,url,webid')->select();
            if(!$web){
                echo json_encode(array('state'=>2,'msg'=>'资源不存在'));exit();
            }
            foreach($web as $item){
                unlink(WEB_ROOT.$item['img']);
                unlink(WEB_ROOT.$item['url']);
            }
            $del = M('music')->where($data)->delete();
            if(!$del){
                echo json_encode(array('state'=>3,'msg'=>'删除失败'));exit;
            }
            $api_webid = M('web_ap')->getFieldByWebid($web[0]['webid'],'id');
            $old = M('webapi')->field('id,influ_ids')->where(array('webid'=>$api_webid,'api'=>'delMusic'))->find();
            $old_id = $old['influ_ids'];
            $new_id = $old_id?$old_id.','.I('get.id',''):I('get.id','');
            $id_arr = explode(',', $new_id);
            $id_arr = array_unique($id_arr);
            $new_id = implode(',',$id_arr);
            $upd['state'] = '1';
            $upd['id'] = $old['id'];
            $upd['influ_ids'] = $new_id;
            M('webapi')->data($upd)->save();
            echo json_encode(array('state'=>0,'msg'=>'删除成功'));exit();
       }
    }
    public function _empty(){
        R('Public/show404');
    }
}
?>
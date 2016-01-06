<?php 
namespace We\Controller;
use Think\Controller;
class VadioController extends Controller{
    private $Vadio;
    private $Public;
    private $Web;
    private $Cate;
    private $Web_Ap;
    private $WebApi;
    public function __construct(){
        parent::__construct();
        $this->Public = new PublicController();
        $this->Public->checkLogin();
        $this->Vadio = M('vadio');
        $this->Web = M('website');
        $this->Cate = M('category');
        $this->Web_Ap = M('web_ap');
        $this->WebApi = M('webapi');
    }
    
    /**
     * 视频组员列表
     */
    public function vadioList(){
       $vadio = $this->Vadio->field('rou_category.cat_name,rou_vadio.*')->join(array('rou_category ON rou_category.id=rou_vadio.cat_id'))->where(array('rou_category.webid'=>I('get.webid'),'type'=>'vadio'))->select();
       $this->assign('vadio',$vadio);
       $this->Public->showHeader();
       $this->display('VadioList');
       $this->Public->showFooter();
    }
    protected function getFilePath(){
        $path = I('param.path');
        $filename = I('param.filename');
        if(!empty($path) && !empty($filename)){
            return $path.$filename;
        }

    }

    protected function updateApi($webid,$api,$id)
    {

        $Api = D('webapi');
        $webap = M('web_ap')->getFieldByWebid($webid,'id');

        $map['api'] = $api;
        $map['webid'] = $webap;
        $Api->create($Api->where($map)->find());

        $influ_ids = empty($Api->influ_ids)?$id:$Api->influ_ids.','.$id;
        $Api->influ_ids = implode(',',array_unique(explode(',',$influ_ids)));
        $Api->state = '1';
        return $Api->save()?true:false;
    }
    /**
     * @example 视频添加
     */
    
    public function vadioAdd(){
        if(IS_POST){

            $Apk = D('vadio');
            $Apk->create();
            $webid = $Apk->webid;

            $config = array(
                'exts' => 'mp4',
                'rootPath' => './',
                'maxSize' => 20*1024*1024,
                'subName' => array(),
                'savePath' => I('post.path','')
            );

            $Upload = new \Think\Upload($config);
            $info = $Upload->uploadOne($_FILES['video']);
            if($Upload->getError()){
                $this->error($Upload->getError());
            }

            $Apk->img = $this->getFilePath('path','filename');
            $Apk->url = $info['savepath'].'/'.$info['savename'];

            if(!$Apk->add()){
                $this->error('视频上传失败');
            }

            $insID = $Apk->getLastInsId();

            $this->updateApi($webid,'getVadio',$insID);

            $this->success('添加成功');

        }else{
            $webid = I('get.webid','');

            $cate = $this->Cate->where(array('webid'=>$webid,'type'=>'video'))->select();
            $web = M('website')->getById($webid);
            $filepath = urlencode(str_replace('/','.',$web['filename'].'/reource'));

            $this->assign('filepath',$filepath);
            $this->assign('cate',$cate);
            $this->Public->showHeader();
            $this->display('VadioAdd');
            $this->Public->showFooter();
        }
    }
    public function vadioDel(){
        
        if(IS_AJAX){
            if(!I('get.id','')){
                echo json_encode(array('state'=>1,'msg'=>'参数错误'));
            }
            
            $data['rou_vadio.id'] = array('in',I('get.id',''));
        
            $web = $this->Vadio->where($data)->field('rou_category.webid')->join('rou_category ON rou_category.id=rou_vadio.cat_id')->select();
            if(!$web){
                echo json_encode(array('state'=>1,'msg'=>'资源不存在'));
            }
            $web = $this->Web->find($web[0]['webid']);

            $del = $this->Vadio->where(array('id'=>array('in',I('get.id',''))))->delete();
            if(!$del){
                echo json_encode(array('state'=>1,'msg'=>'删除失败'));exit;
            }
        
            if(!file_exists(WEB_ROOT.$web['filename'].'/islua.flag')){
        
                //属于静态页面类型，更新首页，重新下载模板包
                $this->WebApi->data(array('state'=>'1'))->where(array('webid'=>$web['id'],'api'=>'downTpl'));
                //更新首页静态文件
                 
                $hd = fopen(WEB_ROOT.$web['filename'].'/index.html','w');
                $content = file_get_contents('http://'.$_SERVER['HTTP_HOST'].$web['filename'].'/index.php?webid='.$web['id']);
                fwrite($hd,$content);
                fclose($hd);
            }else{
        
                //属于动态页面，记录更改的ID
                $query = $this->Web_Ap->where(array('webid'=>$web['id']))->field('id')->find();
                 
                $old = $this->WebApi->field('id,influ_ids')->where(array('webid'=>$query['id'],'api'=>'delVadio'))->find();
                //   var_dump($old);
                $old_id = $old['influ_ids'];
                $new_id = $old_id?$old_id.','.I('get.id',''):I('get.id','');
                //去除重复
                 
                $id_arr = explode(',', $new_id);
                $id_arr = array_unique($id_arr);
                $new_id = implode(',',$id_arr);
                
                 
                $upd['state'] = '1';
                $upd['id'] = $old['id'];
                $upd['influ_ids'] = $new_id;
                
                $this->WebApi->data($upd)->save();
                // echo $WebApi->getLastSql();
            }
             
            echo json_encode(array('state'=>0,'msg'=>'删除成功'));
        
       }
    }
    /**
     * 404
     */
    public function _empty(){
        
        $this->Public->show404();
        
    }
}
?>
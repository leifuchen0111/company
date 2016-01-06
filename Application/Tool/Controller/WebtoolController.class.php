<?php 
namespace Tool\Controller;
use Think\Controller;
class WebtoolController extends Controller{
    private $Website;
    private $WebApi;
    private $web;
    public function __construct($webid){
        
        parent::__construct();
        $this->Website = D('Website');
        $this->Website = D('Webapi');
    }
    
    /**
     * @example 首页内容更新
     * @param $webid 网站ID
     */
    public function updIndex($webid){
        $where['api'] = 'getBaseConf';
        $where['webid'] = $webid;
        $api['state'] = '1';
        $this->WebApi->where($where)->data($api)->save();       
        if(!$this->isLua()){
            $hd = fopen(WEB_ROOT.$this->web['filename'].'/index.html','w');
            $content = file_get_contents('http://'.$_SERVER('HTTP_HOST').$this->web['filename'].'/index.php?webid='.$webid);
            fwrite($hd,$content);
            fclose($hd);
        }
             
    }
    /**
     * @param unknown $webid
     * @param unknown $id
     */
    public function updAds($webid){
        $where['api'] = 'getAds';
        $where['webid'] = $webid;
        $api['state'] = '1';
        $this->WebApi->where($where)->data($api)->save();
        if(!$this->isLua()){
            $hd = fopen(WEB_ROOT.$this->web['filename'].'/index.html','w');
            $content = file_get_contents('http://'.$_SERVER['HTTP_HOST'].$this->web['filename'].'/index.php?webid='.$webid);
            fwrite($hd,$content);
            fclose($hd);
        }
        
    }
    /**
     * 
     * @param unknown $webid
     * @param unknown $id
     */
    public function addPro($webid,$id){
        $data = array();
        $web_ap = M('web_ap')->field('id')->where(array('webid'=>$webid))->select();
        $arr = array();
        foreach($web_ap as $v){
            $arr[] = $v['id'];
        }
        $where = array('api'=>'getProducts','webid'=>array('in',implode(',', $arr)));
        $oldid = $this->WebApi->where($where)->field('influ_ids')->find();
        $data['influ_ids'] = empty($oldid['influ_ids'])?$id:$oldid['influ_ids'].','.$id;
        $data['influ_ids'] = implode(',', array_unique(explode(',', $data['influ_ids'])));
        $this->WebApi->where($where)->data($data)->save();      
    }
    /**
     * 
     * @param unknown $webid
     * @param unknown $id
     */
    public function delPro($webid,$id){
        $arr['state']  = '1';
        $arr['influ_ids'] = I('get.id','');
        $where['api'] = 'delProducts';
        $api_webid = $this->WebApi->field('id')->where(array('webid'=>$webid))->select();
        
        foreach($api_webid as $v){
            $where['webid'] = $v['id'];
            $oldids = $this->WebApi->where($where)->field('influ_ids')->find();
            if($oldids['influ_ids'])  $arr['influ_ids'].=','.$oldids['influ_ids'];
        
            $arr['influ_ids'] = implode(',', array_unique(explode(',', $arr['influ_ids'])));
        
            $this->WebApi->where($where)->data($arr)->save();
        }
    }
    /**
     * 
     * @param unknown $webid
     * @param unknown $id
     */
    public function addNews($webid,$id){
        $web_ap = $this->Web_Ap->field('id')->where(array('webid'=>I('post.id','')))->select();
        foreach($web_ap as $v){
            $webapi = $this->WebApi->field('id,influ_ids')->where(array('webid'=>$v['id'],'api'=>'getNews'))->find();
            $data = array();
            $data['id'] = $webapi['id'];
            $data['state'] = '1';
            $data['influ_ids'] = $webapi['influ_ids']?$webapi['influ_ids'].','.$id:$id;
            $data['influ_ids'] = implode(',', array_unique(explode(',', $data['influ_ids'])));
            $query = $this->WebApi->data($data)->save();
            if(!$query) return false;
            return true;
        }
        
    }
    /**
     * 
     * @param unknown $webid
     * @param unknown $id
     */
    public function delNews($webid,$id){
        $query = $this->Web_Ap->where(array('webid'=>$webid))->field('id')->find();
        $old = $this->WebApi->field('id,influ_ids')->where(array('webid'=>$query['id'],'api'=>'delNews'))->find();
        $old_id = $old['influ_ids'];
        $new_id = $old_id?$old_id.','.$id:$id;
        $id_arr = explode(',', $new_id);
        $id_arr = array_unique($id_arr);
        $new_id = implode(',',$id_arr);
        $upd['state'] = '1';
        $upd['id'] = $old['id'];
        $upd['influ_ids'] = $new_id;
        $query = $this->WebApi->data($upd)->save();
        return $query?true:false;
    }
    /**
     * 
     * @param unknown $webid
     * @param unknown $id
     */
    public function addVideo($webid,$id){
        $api_web = $this->Web_Ap->where(array('webid'=>$webid))->field('id')->select();
        foreach($api_web as $v){
            $api = $this->WebApi->where(array('webid'=>$v['id'],'api'=>'getVadio'))->field('influ_ids,id')->find();
            $data = array();
            $data['state'] = '1';
            $data['influ_ids'] = $api['influ_ids']?$api['influ_ids'].','.$id:$id;
            $data['influ_ids'] = implode(',', array_unique(explode(',', $data['influ_ids'])));
            $data['id'] = $api['id'];
            $this->WebApi->data($data)->save();
        
        }
        
    }
    /**
     * 
     * @param unknown $webid
     * @param unknown $id
     */
    public function delVideo($webid,$id){
        $query = $this->Web_Ap->where(array('webid'=>$webid))->field('id')->find();
         
        $old = $this->WebApi->field('id,influ_ids')->where(array('webid'=>$query['id'],'api'=>'delVadio'))->find();
        //   var_dump($old);
        $old_id = $old['influ_ids'];
        $new_id = $old_id?$old_id.','.$id:$id;
        //去除重复
         
        $id_arr = explode(',', $new_id);
        $id_arr = array_unique($id_arr);
        $new_id = implode(',',$id_arr);
        $upd['state'] = '1';
        $upd['id'] = $old['id'];
        $upd['influ_ids'] = $new_id;
        $this->WebApi->data($upd)->save();
        
    }
    /**
     * 
     * @param unknown $webid
     * @param unknown $id
     */
    public function addApp($webid,$id){
        $api_web = $this->Web_Ap->where(array('webid'=>$webid))->field('id')->select();
        foreach($api_web as $v){
            $api = $this->WebApi->where(array('webid'=>$v['id'],'api'=>'getApk'))->field('influ_ids,id')->find();
            $data = array();
            $data['state'] = '1';
            $data['influ_ids'] = $api['influ_ids']?$api['influ_ids'].','.$id:$id;
            $data['id'] = $api['id'];
            $data['influ_ids'] = implode(',', array_unique(explode(',', $data['influ_ids'])));
            $this->WebApi->data($data)->save();
        
        }
    }
    /**
     * 
     * @param unknown $webid
     * @param unknown $id
     */
    public function delApp($webid,$id){
        $arr['state']  = '1';
        $arr['influ_ids'] = $id;
        $where['api'] = 'delApk';
        
        $api_webid = M('web_ap')->field('id')->where(array('webid'=>$webid))->select();
        foreach($api_webid as $v){
            $where['webid'] = $v['id'];
            $oldids = $this->WebApi->where($where)->field('influ_ids')->find();
            if($oldids['influ_ids'])  $arr['influ_ids'].=$id.','.$oldids['influ_ids'];
            $arr['influ_ids'] = implode(',', array_unique(explode(',', $arr['influ_ids'])));
            $this->WebApi->where($where)->data($arr)->save();
        }
    }
    
    public function updApiN($webid,$api){
        
        
    }
    
    public function updApi($webid,$api,$id){
        if(empty($webid) || empty(($api))) return false;
        $this->web = $this->Website->find($webid);
            switch ($api){
                case 'index':
                    $this->updIndex($webid);
                    break;
                case 'ads':
                    $this->updAds($webid);
                    break;
                case 'addproduct':
                    $this->addPro($webid, $id);
                    break;
                case 'addnews':
                    $this->addNews($webid, $id);
                    break;
                case 'addvideo':
                    $this->addVideo($webid, $id);
                    break;
                case 'addapp':
                    $this->addApp($webid, $id);
                    break;
                case 'delproduct':
                    $this->delPro($webid, $id);
                    break;
                case 'delnews':
                    $this->delNews($webid, $id);
                    break;
                case 'delapp':
                    $this->delApp($webid, $id);
                    break;
                case 'delvideo':
                    $this->delVideo($webid, $id);
                    break;
                default:
                    break;
                
            }
       
        
    }
    
    private function isLua(){
        return file_exists(WETPL_PATH.$this->web['tpl_style'].'/islua.flag')?true:false;
    }
    
    
    
    
}
?>
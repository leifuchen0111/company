<?php
namespace We\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function __construct(){
        parent::__construct();
        $Public = new PublicController();
        $Public->checkLogin();
    }
    
    
    public function index(){
        $Public = new PublicController();
        $Website = D('website');
        $data['gw_id'] = array('eq',I('get.gw_id',''));
        $data['rid'] = array('eq',I('get.id',''));
        $data['_logic'] = 'or';
        $websites = $Website->where($data)->select();
        $this->assign('websites',$websites);
        $Public->showHeader();
        $Public->showFooter();
        
    }

    /**
     * 站点管理
     */
    public function webmanage(){
        $webid = I('get.webid','');
        $Public = A('Public');
        $Web = M('website');
        $web = $Web->getById($webid);
        
        $this->assign('data',$web);
        $Public->showHeader();
        $this->display('index');  
        $Public->showFooter();
    }
    /**
     * 网站基本信息设置
     */
    public function webconf(){
      if(IS_POST){
          $Website = D('website');
          $Website->create();
          $id = $Website->id;
          if($Website->logo == '')
          {
              unset($Website->logo);
          }
          if($Website->save())
          {
              $this->updApi($id,'getBaseConf');
              $this->success('修改成功');
          }
          else
          {
              $this->error('修改失败');
          }

      }else{
          $id = I('get.webid','');
          $Website = M('website');
          $Public = A('Public');

          $web = $Website->find($id);
          $path =str_replace( '/','.',$web['filename'].'/resource');

          $this->assign('data',$web);
          $this->assign('filepath',$path);
          $Public->showHeader();
          $this->display();
          $Public->showFooter();
      }
    }

    public function download(){
        $r_mac = I('param.mac','');
        $Public = A('Public');
        $webid = I('get.id','');
        $Web = M('website');
        $web = $Web
                ->join('rou_ap_main on rou_ap_main.id=rou_website.rid')
                ->where('rou_ap_main.mac='.$r_mac)
                ->find();
        foreach($web as $k=>$v){
            if($v === '') $Public->error('请先配置站点');
        }
        $WebNav = M('webnav');
        $nav = $WebNav->where(array('wid'=>$webid,'is_show'=>1))->select();
        $navStr = '';
        foreach($nav as $item){
            $navStr.='<option>'.$item['navname'].'</option>';
        }
        $path = '/Down/'.$web['filename'].'/';
        //生成配置文件
        $config = '<title>'.$web['web_name'].'</title>
        <address>'.$web['address'].'</address>
        <phone>'.$web['phone'].'</phone>
        <email>'.$web['email'].'</email>
        <nav>'.$navStr.'</nav>';
        $suffix = date('YmdHis',time()).'_'.rand(0,999);
        $hd = fopen(WEB_ROOT.$path.'config_'.$suffix.'.txt','w') or die('无法打开文件');
        fwrite($hd, $config);
        fclose($hd);
        $zip = new \Org\Util\PHPZip();
        $zip->ZipAndDownload(WEB_ROOT.$path);
    }

    protected function updApi($webid,$api,$id){
        //更新api信息
        $Api = M('webapi');
        $arr['state']  = '1';
        $arr['influ_ids'] = $id;
        $where['api'] = $api;
        $api_webid = M('web_ap')->field('id')->where(array('webid'=>$webid))->select();
        foreach($api_webid as $v){
            $where['webid'] = $v['id'];
            $oldids = $Api->where($where)->field('influ_ids')->find();

            if(!$oldids){
                $where['order'] = '10';
                $Api->add($where);

            }
            if($oldids['influ_ids'])  $arr['influ_ids'].=','.$oldids['influ_ids'];
            $arr['influ_ids'] = implode(',', array_unique(explode(',', $arr['influ_ids'])));
            $Api->where($where)->data($arr)->save();


        }
    }
    /**
     * 404
     */
    public function _empty(){
        $Public = new PublicController();
        $Public->show404();
    }
}

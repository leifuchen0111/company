<?php 
namespace We\Controller;
use Think\Controller;
class WebbuildController extends Controller{
    public function __construct(){
        parent::__construct();
        $Public = new PublicController();
        $Public->checkLogin();
    }



    public function webAdd(){
        $Public = new PublicController();
        $Web = M('website');
        $Web_Ap = M('web_ap');
        if(IS_AJAX){
            $data['tpl_style'] = I('post.tpl_style');
            $data['web_name'] = I('post.title','');

            $data['address'] = I('post.address','');
            $data['copyright'] = I('post.copyright','');
            $data['phone'] = I('post.phone','');

            $ssid = I('post.ssid','');
            $ssid_arr = array_unique(explode(',',$ssid));
            sort($ssid_arr);
            $len = count($ssid_arr);
            //echo json_encode(array('state'=>1,'msg'=>$len));exit;
            for($i=0;$i<$len;$i++){
                $apsingle = explode('_', $ssid_arr[$i]);
                if($Web_Ap->where(array('ssid'=>$apsingle[0],'gw_id'=>$apsingle[1]))->find()){
                    echo json_encode(array('state'=>1,'msg'=>'路由：'.$apsingle[1].',对应热点：'.$apsingle[0].'已存在站点，请先删除站点!'));exit;
                }
                
            }

            $data['uid'] = session('userId') ? session('userId') : 1;
            $filename = $data['tpl_style'].date('YmdHis',time()).rand(0,999);
            if(!is_dir(WEB_ROOT.'/Down/'.session('name'))) mkdir(WEB_ROOT.'/Down/'.session('name'));
            $dst = WEB_ROOT.'/Down/'.session('name').'/'.$filename;
            $Public->recurse_copy(WEB_ROOT.'/MediaTpl/'.$data['tpl_style'],$dst);
            $data['filename'] = '/Down/'.session('name').'/'.$filename;
            $webFileName = $data['filename'];
            if(file_exists(WEB_ROOT.'/MediaTpl/'.$data['tpl_style'].'/dingcan.flag')) $data['type'] = '1';
            $insertId = $Web->data($data)->add();
            //生成微信菜单
            $Api = M('webapi');
	//	echo json_encode(array('state'=>0,'msg'=>$len));
            for($i=0;$i<$len;$i++){
                $apsingle = array();
                $apsingle = explode('_', $ssid_arr[$i]);
                $leng = count($apsingle);
                $data['gw_id'] = $apsingle[$leng-1];
                unset($apsingle[$leng-1]);
                $ssid = implode('_',$apsingle);
                $data['ssid'] = $ssid;
                $data['webid'] = $insertId;
                $Web_Ap->data($data)->add();

                $queryId = $Web_Ap->getLastInsID();
                $data = array(  'api'   => 'downTpl',
                        'webid' => $queryId,
                        'order' => '100',
                        'state' => '1'
                    );


                $Api->data($data)->add();


             }
            
            if($queryId){
                echo json_encode(array('state'=>0,'msg'=>'建站成功','url'=>'/Webbuild/index.php/Webconf/webConf/id/'.$insertId));
            }else{
                echo json_encode(array('state'=>1,'msg'=>'建站失败'));
            }
        }else{
            $Public->show404();
        }
        
    }


    /*public function webAdd(){

        $style = I('post.tpl_style','');

        $Action =  A($style.'/Index');

        $query = $Action->add();

        exit($query);


    }*/
}
?>

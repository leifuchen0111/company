<?php
namespace Android\Controller;
use Think\Controller; 
class PublicController extends Controller{
   /**
    * 登陆
    */ 
  public function Login(){
      if($_POST){
          
          $inputVerify = md5(I('post.verify',''));
          if($inputVerify!=$_SESSION['verify']){
              $this->error('验证码错误');
          }
         
          $User = D('User');
          //自动验证数据
          $data = $User->create();
         
          if(!$data){
              $this->error($User->getError());
          }    
          $data['is_ok'] = '2';
        //  var_dump($data);die;
            $query = $User->where($data)->find();
          if($query){
              session('name',$User->name);
              session('lasttime',date('Y-m-d H:i:s',$query['lasttime']));
              session('lastip',$query['lastip']);
              session('userId',$query['id']);
              session('is_log',1);
              session('role',$this->getRole());
              session('style',$query['mudel_style']);
              //记住登陆状态
              if(I('post.remember','')){
                  $exp = 7*24*3600;
                  cookie('name',$User->name,$exp);
                  cookie('userId',$query['id'],$exp);
                  cookie('is_log',1,$exp);
                  cookie('role',$this->getRole(),$exp);
                  cookie('style',$query['mudel_style'],$exp);
              }else{
                  cookie(null);
              }
              //启动事务
              $User->startTrans();
              //更新登陆数据
              $data['id'] = $User->id;      
              
              $User->create($data);             
              if($User->save()){
                  //提交事务
                  $User->commit();
                  $this->success('登陆成功',U(C('DEFAULT_MODULE').'/'.C('DEFAULT_ACTION')));
              }else{
                  $User->rollback();
                  $this->error('登陆失败!');
              }
 
          }else{
              // echo $User->getLastSql();die;
              $this->error('账号或密码错误!');
          }
      }else{
          $this->display('Public/login');
      }
  }

  /**
  * 检查登陆
  */
    public function checkLogin(){
         $User = M('user');
         $data['name'] = I('get.name','');
         
         $data['pwd'] = substr(md5(I('get.pwd','')), 1,30);
         
         if($User->where($data)->find()){
             $Order = A('order');
             $order = $Order->getOrder($data['name']);
            
             echo json_encode(array('state'=>1,'info'=>$order));
             
         }else{
            // echo urlencode('!@#');
             echo json_encode(array('state'=>0));
         }
       
    }
  /**
   * 登出
   */
  public function Logout(){
      session_unset();
      session_destroy();
      
      cookie('name',null);
      cookie('is_log',null);
      cookie('userId',null);
      $this->success('退出成功',U('Public/login'));
  }
  
  /**
   * 显示头部
   */
  public function showHeader(){
      /* if(file_exists(HTML_PATH.'/'.session('role').'/Public/header.html')){
          $content = file_get_contents(HTML_PATH.'/'.session('role').'/Public/header.html');
          echo $content;
      } */
      $User = D('User');
      $Action = D('Action');
      $Role = D('Role');
      //获取侧边栏导航
      $actions = array();
      $actions = F(session('name').'/actions');
      if(!$_SESSION['actions'] || !$actions || !$_SESSION['actions_str']){
          if($_SESSION['userId'] != 1){
              //查询用户的角色
              $query = $User->relation('role')->where(array('id'=>session('userId')))->find();

             //查节点
              $role = $Role->relation('action')->getById($query['role']['id']);
              $lenght = count($role['action']);
              //判断是否显示
              $actions = array();
              for($i=0;$i<$lenght;$i++){
                  if($role['action'][$i]['is_show'] == '0') continue;
                 
                  array_push($actions, $role['action'][$i]);
              }
              
          }else{
              $actions = $Action->where(array('is_show'=>array('gt','0')))->select();
          }
        
          
          $len = count($actions);
          $actArr = array();
          //重组 父子导航
          for($i=0;$i<$len;$i++){
              $actions[$i]['cnav'] = array();
              foreach($actions as $item){
                  if($item['p_id'] == $actions[$i]['id']){
                      if($item['is_show'] != 2){
                        array_push($actions[$i]['cnav'],$item);
                      }else{
                          array_push($actarr,$item);
                      }
                  }
              }
              $actArr[] = $actions[$i]['node'];
              if($actions[$i]['p_id']!=0) unset($actions[$i]);
          }
          session('actions',array_unique($actArr));
          session('actions_str',implode(',', $_SESSION['actions']));
          F(session('name').'/actions',$actions);
         
         
      }
      
      /*获取系统消息*/
      //新用户注册信息
      $User = D('user');
      $data['is_ok'] = '0';
      $data['pid'] = session('userId');
      $auditUser = $User->where($data)->count();
      
      $this->assign('auditUser',$auditUser);
      
      
      $this->assign('main_nav',$actions);

   //   var_dump($actions);die;
  //    $this->buildHtml('header',HTML_PATH.'/'.session('role').'/Public/','Public/header');
      
  //    var_dump($actions);die;
   //   $this->display('Public/header');
      $this->showIndexDashboard();
  }
  /**
   * @example 用户权限分配时，显示所有操作节点
   * @return mixed
   */
  public function getAllActions(){
      $User = D('User');
      $Action = D('Action');
      $Role = D('Role');
      $actions = array();
      $role = $Role->field('id')->getByFlag(session('role'));
      if($role['id']!=1){
          $sql = 'SELECT a.* FROM `rou_action` a LEFT JOIN `rou_act_role` c on c.`a_id`=a.`id` WHERE c.`r_id`='.$role['id'].' AND a.`is_show`>0';
        //  $actions = $Action->where(array('is_show'=>array('gt','0')))->select();
       // echo $sql;
          $actions = $Action->query($sql);
      }else{
          $actions = $Action->where(array('is_show'=>array('gt','0')))->select();
      }
      $len = count($actions);
      //重组 父子导航
      for($i=0;$i<$len;$i++){
          $actions[$i]['cnav'] = array();
          foreach($actions as $item){
              if($item['p_id'] == $actions[$i]['id']){
                 
                      array_push($actions[$i]['cnav'],$item);
                 
                  
              }
          }
          if($actions[$i]['p_id']!=0) unset($actions[$i]);
      }
   //   var_dump($actions);die;
      return $actions;
      
  }
  /**
   * 显示公共底部
   */
  Public function showFooter(){
   //   $this->display('Public/footer');
  }
  /**
   * 显示详细页头部
   */
  public function showDetailHeader(){
      $ApMain = D('ApMain');
      $rid =explode(',',I('param.id',''));
      
      $gw_id = explode(',',I('param.gw_id',''));
      if(I('param.id','')){
          $len = count($rid);
          for($i=0;$i<$len;$i++){
              $ap[] = $ApMain->field('id,gw_id,hwserial')->getById($rid[$i]);
          }
          $id = '';
          $gw_id = '';
         
        foreach($ap as $item){
            $apInfo['id'].=$item['id'].',';
            $apInfo['gw_id'].=$item['gw_id'].',';
            $apInfo['hwserial'].=$item['hwserial'].',';
        }
        $apInfo['id'] = substr($apInfo['id'],0,-1);
        $apInfo['gw_id'] = substr($apInfo['gw_id'],0,-1);
        $apInfo['hwserial'] = substr($apInfo['hwserial'],0,-1);
        
      }else{
          $len = count($gw_id);
          for ($i=0;$i<$len;$i++){
              $ap[] = $ApMain->field('id,gw_id,hwserial')->getByGw_id($gw_id[$i]);
          }
          $id = '';
          $gw_id = '';
          
          foreach($ap as $item){
              $apInfo['id'].=$item['id'].',';
              $apInfo['gw_id'].=$item['gw_id'].',';
              $apInfo['hwserial'].=$item['hwserial'].',';
          }
          
          $apInfo['id'] = substr($apInfo['id'],0,-1);
          $apInfo['gw_id'] = substr($apInfo['gw_id'],0,-1);
          $apInfo['hwserial'] = substr($apInfo['hwserial'],0,-1);
      }
      
      $this->assign('apInfo',$apInfo);

      $this->showDetailDashboard();
  }
  /**
   * 显示详细页底部
   */
  public function showDetailFooter(){
    //  $this->display('Public/footer_detail');
  }
  /**
   * 窗口弹出提示信息
   * @param $str 提示内容
   */
  public function alert($str){
      
      echo '<script>alert("'.$str.'")</script>';
  }
  
  /**
   * 检查权限
   * @param $actName 操作名称
   */
  public function checkAcess($actName){
      
      if($this->getRole() !='super'){
          
        if(!in_array($actName,$_SESSION['actions'])){ $this->show404();exit;}
      }
      
      
      
  }
  /**
   *获取用户所有操作节点
   *@param $id 用户id
   *@return array
   */
  public function getNav($id){
      $role_id = M('user_role')->field('r_id')->where('u_id='.$id)->find();
      //权限检测跳过超级管理员
      session('userLimit','');
      if($role_id['r_id'] != 1){
          $Act_role = M('act_role');
          $action_id = $Act_role->field('a_id')->where('r_id='.$role_id['r_id'])->select();
          $arr = array();
          foreach($action_id as $item){
              array_push($arr,$item['a_id']);
          }
          $where['id'] = array('in',$arr);
  
          //用户id条件，预留
          $str = ',"uid"=>'.session('userId');
          session('userLimit',$str);
  
      }
      $action = M('action')->field('id,p_id,action,node')->where($where)->select();
      return $action;
  }
  /**
   *获取用户当前操作权限
   *@param $id 用户id
   *@param $act 当前操作名称
   *@return boolen
   */
  public function getAccess($id,$act){
      $action = $this->getNav($id);
      if(in_array($act,$action)){
          return true;
      }else{
          return false;
      }
  
  }
  /**
   *查询用户节点权限，赋值模板
   *
   */
  public function tpl(){
      $action = $this->getNav(session('userId'));
      $main_nav = array();
      foreach($action as $item){
          if($item['p_id'] === '0'){
              array_push($main_nav,$item);
          }
      }
      $this->assign('nav',$action);
      $this->assign('main_nav',$main_nav);
      	
  }
  
  /**
   * 获取用户角色信息
   *
   */
  public function getRole(){
      $Role = M('role');
      $role = $Role
      ->field('rou_role.flag')
      ->join('rou_user on rou_user.role_id=rou_role.id')
      ->where(array('rou_user.id'=>session('userId')))
      ->find();
      return $role['flag'];
  }
  
  /**
   * 判断用户查看路由器权限
   *@param $id 路由器id
   */
  public function haveJsd($rid){
     
      
          $aps = $this->treeAp($_SESSION['userId']);
         
          $arr = array();
          foreach($aps as $item){
              $arr[] = $item['id'];
              $arr[] = $item['gw_id'];
          }
    //  var_dump($arr);echo $rid;die;
      if(in_array($rid,$arr)){
          return true;exit;
      }else{
          $this->show404();exit;
      }
  }
  
  public function modelName(){
      $html['open'] = MODULE_NAME;
      $this->assign('html',$html);
  }
  
  /**
   * 获取账户下面的所有代理及用户
   * @param int 用户id
   * @return array
   */
  public function treeUser($id){
      $arr = F(session('name'.'/member'));
      if(empty($arr) || !$arr){
          static $tree = array();
          $User = D('user');
          $data = $User->where(array('pid'=>$id))->select();
          !in_array($data,$tree)?$tree[] = $data:'';
          if($data){
              foreach($data as $item){
                  if(!is_array($item)){
                      continue;
                  }else{
                      $this->treeUser($item['id']);
                      
                  }
          
              }
          }
          $arr = array();
          foreach($tree as $item){
              if(!$item) continue;
              foreach($item as $v){
                  $v['role_id']=='3'?$arr['user'][] = $v:$arr['agent'][] = $v;
              }
          }
          F(session('name').'/member',$arr);
      }
      return $arr;
  }
  /**
   * 获取账户下所有Ap
   * @param int 用户id
   * @return array
   */
  public function treeAp($id){
          
            
          $return = F(session('name').'/Ap');
          if(!$return){
         //echo 'ss';die;
          $ApMain = D('ApMain');
          $arr = array();
          $user = $this->treeUser($id);
          
          foreach ($user as $c1){
              
              foreach($c1 as $c2){
                  $arr[] = $ApMain->where(array('uid'=>$c2['id']))->select();
              }
          }
          //用户账号的直属AP
          $arr[] = $ApMain->where(array('uid'=>session('userId')))->select();
          $return = array();
          foreach($arr as $c1){
              foreach($c1 as $c2){
                  $return[] = $c2;
              }
          }
            F(session('name').'/Ap',$return);
            //S('Ap',$return,'3600','File',array('lenght'=>10,'temp'=>RUNTIME_PATH.'temp/'.session('name').'/'));  
        }
     
      
      
      return $return;
  }
  
  /**
   * 获取账户下所有mac
   * @param int 用户id
   * @return array
   */
  public function treeMac($id){
      $data = F(session('name').'/Mac');
      if(!$data){
          $Mac = D('mac');
          $ap = $this->treeAp($id);
          $arr = array();
          foreach($ap as $c1){
              $arr[] = $Mac->where(array('rid'=>$c1['id']))->select();
          }
          
          $data = array();
          foreach($arr as $c1){
              foreach ($c1 as $c2){
                  $c2['status'] == 1?$data['online'][]=$c2:$data['history'][]=$c2;
              }
          }
          F(session('name').'/Mac',$data);
      }
      return $data;
  }
  /**
   * 获取短信数量
   */
  public function getRemainMsgNum(){
      if($_SESSION['userId'] == 1){
          $Api = A('Api');
          return $Api->getRemainMsgCount();
      }else{
          $UserInfo = M('userinfo');
          $user_info = $UserInfo->field('msgnum')->getByUserid($_SESSION['userId']);
          return $user_info['msgnum'];
      }
  }
  /**
   * 获取流量总计
   * @param int 用户id
   * @return array
   */
  public function getBw($id){
          $arr = array();
          $mac = $this->treeMac($id);
          $Bw = D('Bw');
          $arr = array();
          foreach($mac as $c1){
              
              foreach ($c1 as $c2){
                 
                  $arr['bw_up']+= $Bw->where(array('mid'=>$c2['id']))->sum('bw_up');
                  $arr['bw_down']+= $Bw->where(array('mid'=>$c2['id']))->sum('bw_down');
              }
          }
        //  F(session('name').'/Bw',$arr);
      
      
      return $arr;
  }
  
  /**
   * AP上行流量
   * @param int 用户id
   * @return array
   */
  public function getFlowByAp($id){
      $Mac = D('mac');
      $Bw = D('Bw');
      $Ap = D('ApMain');
      $ap = $this->treeAp($id);
   //   var_dump($ap);
      $arr = array();
      //获取每个AP下面的mac
      foreach($ap as $c1){
          $arr[$c1['hwserial']] = $Mac->where(array('rid'=>$c1['id']))->select();
      }
      
    //  var_dump($arr);die;
      $len1 = count($arr);
      
      //获取每个AP下面各MAC流行之和
      $apBw = array();
      foreach($arr as $k=>$v){
          $apid = $k;
          
          foreach($v as $item){
            //  var_dump($item);
              $apBw[$apid]['bw_up']+=$Bw->where(array('mid'=>$item['id']))->sum('bw_up'); 
              $apBw[$apid]['bw_down']+=$Bw->where(array('mid'=>$item['id']))->sum('bw_down'); 
              
              
          }
          
      }
      
      return $apBw;
  }
  /**
   * AP下行流量
   * @param int 用户id
   * @return array
   */
  public function getDownFlowByAp($id){
      $Mac = D('mac');
      $Bw = D('Bw');
      $Ap = D('ApMain');
      $ap = $this->treeAp($id);
      $arr = array();
      //获取每个AP下面的mac
      foreach($ap as $c1){
          $arr[$c1['id']] = $Mac->where(array('rid'=>$c1['id']))->select();
      }
     // var_dump($arr);die;
      $len1 = count($arr);
      
     
      //获取每个AP下面各MAC流行之和
      $apBw = array();
      for($i=0;$i<$len1;$i++){
          $len2 = count($arr[$i]);
          for($j=0;$j<$len2;$j++){
              $apBw[$i]+= $Bw->where(array('mid'=>$arr[$i][$j]['id']))->sum('bw_down'); 
              
          }
          
      }
      $arr = array();
      foreach($apBw as $k=>$v){
          $arr[$k] = $Ap->field('fw,rmac,id,hwserial')->getById($k);
          $arr[$k]['bw_down'] = $v;
      }
      
      return $arr;
  }
 /**
  * 将kb为单位的流量转换成tgmk为单位的流量
  * @param unknown $kb
  */
  public function KbtoMb($kb){
      
      $g = round($kb/1000000000,2);
      return "{$g}G";
  }
  /**
   * 用户登陆时，获取路由信息
   */
  
  public function update(){
      $ap = $this->treeAp(session(userId));
      
      
  }
  /**
   * 批量文件上传
   */
  public function fileupload(){
      
      header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
      header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
      header("Cache-Control: no-store, no-cache, must-revalidate");
      header("Cache-Control: post-check=0, pre-check=0", false);
      header("Pragma: no-cache");
      
      
      // Support CORS
      // header("Access-Control-Allow-Origin: *");
      // other CORS headers if any...
      if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
          exit; // finish preflight CORS requests here
      }
      
      
      if ( !empty($_REQUEST[ 'debug' ]) ) {
          $random = rand(0, intval($_REQUEST[ 'debug' ]) );
          if ( $random === 0 ) {
              header("HTTP/1.0 500 Internal Server Error");
              exit;
          }
      }
      
      // header("HTTP/1.0 500 Internal Server Error");
      // exit;
      
      
      // 5 minutes execution time
      @set_time_limit(5 * 60);
      
      // Uncomment this one to fake upload time
      usleep(5000);
      
      // Settings
      // $targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
      $targetDir = WEB_ROOT.'/Upload_tmp';
      $uploadDir = WEB_ROOT.'/Uploads/product/'.session('name');
      
      $cleanupTargetDir = true; // Remove old files
      $maxFileAge = 5 * 3600; // Temp file age in seconds
      
      
      // Create target dir
      if (!file_exists($targetDir)) {
          @mkdir($targetDir);
      }
      
      // Create target dir
      if (!file_exists($uploadDir)) {
          @mkdir($uploadDir);
      }
      
      // Get a file name
      
      $fileName = uniqid("file".time()).'.jpg';
      
      
      $md5File = @file('md5list.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
      $md5File = $md5File ? $md5File : array();
      
      if (isset($_REQUEST["md5"]) && array_search($_REQUEST["md5"], $md5File ) !== FALSE ) {
          die('{"jsonrpc" : "2.0", "result" : null, "id" : "id", "exist": 1}');
      }
      
      $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
      $uploadPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;
      
      // Chunking might be enabled
      $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
      $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 1;
      
      
      // Remove old temp files
      if ($cleanupTargetDir) {
          if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
              die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
          }
      
          while (($file = readdir($dir)) !== false) {
              $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;
      
              // If temp file is current file proceed to the next
              if ($tmpfilePath == "{$filePath}_{$chunk}.part" || $tmpfilePath == "{$filePath}_{$chunk}.parttmp") {
                  continue;
              }
      
              // Remove temp file if it is older than the max age and is not the current file
              if (preg_match('/\.(part|parttmp)$/', $file) && (@filemtime($tmpfilePath) < time() - $maxFileAge)) {
                  @unlink($tmpfilePath);
              }
          }
          closedir($dir);
      }
      
      
      // Open temp file
      if (!$out = @fopen("{$filePath}_{$chunk}.parttmp", "wb")) {
          die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
      }
      
      if (!empty($_FILES)) {
          if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
              die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
          }
      
          // Read binary input stream and append it to temp file
          if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
              die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
          }
      } else {
          if (!$in = @fopen("php://input", "rb")) {
              die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
          }
      }
      
      while ($buff = fread($in, 4096)) {
          fwrite($out, $buff);
      }
      
      @fclose($out);
      @fclose($in);
      
      rename("{$filePath}_{$chunk}.parttmp", "{$filePath}_{$chunk}.part");
      
      $index = 0;
      $done = true;
      for( $index = 0; $index < $chunks; $index++ ) {
          if ( !file_exists("{$filePath}_{$index}.part") ) {
              $done = false;
              break;
          }
      }
      if ( $done ) {
          if (!$out = @fopen($uploadPath, "wb")) {
              die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
          }
      
          if ( flock($out, LOCK_EX) ) {
              for( $index = 0; $index < $chunks; $index++ ) {
                  if (!$in = @fopen("{$filePath}_{$index}.part", "rb")) {
                      break;
                  }
      
                  while ($buff = fread($in, 4096)) {
                      fwrite($out, $buff);
                  }
      
                  @fclose($in);
                  @unlink("{$filePath}_{$index}.part");
              }
      
              flock($out, LOCK_UN);
          }
          @fclose($out);
      }
      
      // Return Success JSON-RPC response
      die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
  }
  /**
   * 验证码
   */
  public function verify(){
     
      import('ORG.Util.Image');
      Image::buildImageVerify();
   
      
  }
  /**
   * @example 清除缓存
   */
  public function delCache(){
      $dir = scandir(WEB_ROOT.'/Route/Runtime/Data/'.session('name').'/');
      $len = count($dir);
      for($i=0;$i<$len;$i++){
         if($dir[$i] == '0' || $dir[$i] == '..') continue;
         unlink(WEB_ROOT.'/Route/Runtime/Data/'.session('name').'/'.$dir[$i]);
         
      }
      
      $this->success('缓存清除成功');
      
  }
  
 /**
  * 显示控制面板
  */
  public function showIndexDashboard(){
     /*  if(file_exists(HTML_PATH.'/'.session('role').'/Public/indexHeader.html')){
          $content = file_get_contents(HTML_PATH.'/'.session('role').'/Public/indexHeader.html');
          echo $content;
      } */
      $Mac = D('Mac');
      $ApMain = D('ApMain');
      $User = D('User');
      //将离线的路由上的 所有用户强制下线
      
      $arr['last_ping_time'] = array('lt',time()-200);
      $id = $ApMain->where($arr)->field('id')->select();
      $idOne = array();
      foreach($id as $item){
          $idOne[] = $item['id'];
      }
      $id_str = implode(',', $idOne);
      $MacOutLine['rid'] = array('in',$id_str);
      $s['status'] = '0';
      $Mac->where($MacOutLine)->save($s);
      
      //获取代理商和商户数量
      $arr= $this->treeUser($_SESSION['userId']);
      $data['agent_count'] = count($arr['agent']);
      //   echo json_encode($new);die;
      $data['user_count'] = count($arr['user']);
      
      
      //获取子级AP
      $ap = $this->treeAp($_SESSION['userId']);
      $data['ap_count'] = count($ap);
      //获取用户MAC
      $mac = $this->treeMac($_SESSION['userId']);
      $data['mac_online_count'] = count($mac['online']);
      $data['mac_history_count'] = count($mac['history']);
      
      //获取流量
      $bw = $this->getBw($_SESSION['userId']);
   //   var_dump($bw);die;
      $data['bw_up_count'] = $this->KbtoMb($bw['bw_up']);
      $data['bw_down_count'] = $this->KbtoMb($bw['bw_down']);
      
      //短信数量,用于认证是短信的发送
      $data['short_msg_count'] = $this->getRemainMsgNum();
      
      $this->assign('indexTj',$data);
      
     // $this->buildHtml('header',HTML_PATH.'/'.session('role').'/Public/','Public/header');
      
  //    $this->display('Ap/index');
  }
  /**
   * 显示单路由的控制面板
   */
  public function showDetailDashboard(){
    //  $this->display('Public/detailDashboard');
  
  }
  /**
   * 404
   */
    public function show404(){
        header('HTTP/1.0 404 Not Found');
        $this->showHeader();
        $this->display('Public/404');
        $this->showFooter();
    }
    
    /**
     * 验证验证码
     */
    public function checkVerify(){
        
        $inputVerify = md5(I('get.verify',''));
        if($inputVerify!=$_SESSION['verify']){
            echo json_encode(array('state'=>1));
        }else{
            echo json_encode(0);
        }
    }
    /**
     * 设置主题颜色
     */
    public function setColor(){
        $color = I('get.color','');
        session('style',$color);
        $User = M('user');
        $data['mudel_style'] = $color;
        $data['id'] = session('userId');
        $User->data($data)->save();
    }
  
  /**
   * 404
   */
  public function _empty(){
    
      $this->show404();
  }
}
?>
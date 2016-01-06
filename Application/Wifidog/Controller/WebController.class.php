<?php
namespace Wifidog\Controller;
use Think\Controller;
class WebController extends Controller{
    private $api;
    public function _empty(){
        header('HTTP/1.0 404 Not Found');
        die('api error');
    }
    public function index(){
        $this->api = I('get.action');
        $web = $this->getWebId();

        if(is_dir('./Application/'.$web['tpl_style']) && $this->api != 'downTpl'){

            C('DB_PREFIX','rou_'.$web['tpl_style'].'_');

            R($web['tpl_style'].'/Api/'.$this->api,$_GET);

        }else{

            R('web/'.I('get.action','_empty'),$_GET);
        }


    }
    public function updApi($api){
        $where['gw_id'] = I('get.gw_id','');
        $where['ssid'] = I('get.ssid','');
        $apiid = M('web_ap')->where($where)->getField('id');
        $influ_id = M('webapi')->where(array(
                                    'webid' => $apiid,
                                    'api' => I('get.action')
                                ))
                                ->field('id,influ_ids')
                                ->find();
        $upd['influ_ids'] = '';
        $upd['state'] = '0';
        $upd['id'] = $influ_id['id'];
        M('webapi')->save($upd);

        return $influ_id['influ_ids'];
    }
    public function getBaseConf(){
        $web = $this->getWebId();
        $webid = (int)$web['id'];
        $this->updApi(ACTION_NAME);
        echo $this->decodeUnicode(json_encode($web));exit;
    }
    public function editCat(){

        $id = $this->updApi(ACTION_NAME);
        $cate = M('category')->where(array('cid'=>array('in',$id)))->select();
        echo $this->decodeUnicode(json_encode($cate));exit;

    }
    public function getNav(){
        $web = $this->getWebId();
        $webid = (int)$web['id'];

        $nav = M('webnav')
                ->where(array(
                    'webid' => $webid,
                    'is_show' => '1'
                ))
                ->select();
        $this->updApi(ACTION_NAME);
        echo $this->decodeUnicode(json_encode($nav));exit();
    }
    public function delAds(){
        $web = $this->getWebId();
        $webid = (int)$web['id'];
        $id = explode('.', $this->updApi(ACTION_NAME));
         $where = array(
             'webid' => $webid,
         );
        $ads_num = M('ads')->where($where)->select();
        if(!$ads_num){
            echo json_encode(array('id'=>true));exit;
        }
        if(!$ads_num){
            echo json_encode(array('id'=>true));exit;
        }
        $arr = array();
        $length = count($id);
        $return = array();
        for($i=0;$i<$length;$i++){
            $return[$i] = array('id'=>$id[$i]);
        }
        echo json_encode($return);exit;
    }
    public function delProducts(){
        $web = $this->getWebId();
        $webid = (int)$web['id'];
        $id = explode('.', $this->updApi(ACTION_NAME));
        $ads_num = M('product')->getFieldByWebid($webid,'id');
        if(!$ads_num){
            echo json_encode(array('id'=>true));exit;
        }
        $arr = array();
        $length = count($id);
        $return = array();
        for($i=0;$i<$length;$i++){
            $return[$i] = array('id'=>$id[$i]);
        }
        echo json_encode($return);exit;
    }
    public function delCat(){

        $web = $this->getWebId();
        $webid = (int)$web['id'];
        $id = explode('.', $this->updApi(ACTION_NAME));
        $ads_num = M('category')->getFieldByWebid($webid,'id');
        if(!$ads_num){
            echo json_encode(array('id'=>true));exit;
        }
        $arr = array();
        $length = count($id);
        $return = array();
        for($i=0;$i<$length;$i++){
            $return[$i] = array('id'=>$id[$i]);
        }
        echo json_encode($return);exit;
    }
    public function delApk(){
        $web = $this->getWebId();
        $webid = (int)$web['id'];
        $id = explode('.', $this->updApi(ACTION_NAME));
        $ads_num =M('apk')->getFieldByWebid($webid,'id');
        if(!$ads_num){
            echo json_encode(array('id'=>true));exit;
        }
        $arr = array();
        $length = count($id);
        $return = array();
        for($i=0;$i<$length;$i++){
            $return[$i] = array('id'=>$id[$i]);
        }
        echo json_encode($return);exit;
    }
    public function delMusic(){
        $web = $this->getWebId();
        $webid = (int)$web['id'];
        $id = explode('.', $this->updApi(ACTION_NAME));
        $ads_num =M('music')->getFieldByWebid($webid,'id');
        if(!$ads_num){
            echo json_encode(array('id'=>true));exit;
        }
        $arr = array();
        $length = count($id);
        $return = array();
        for($i=0;$i<$length;$i++){
            $return[$i] = array('id'=>$id[$i]);
        }
        echo json_encode($return);exit;
    }
    public function delShop(){
        $web = $this->getWebId();
        $webid = (int)$web['id'];
        $id = explode('.', $this->updApi(ACTION_NAME));
        $ads_num =M('shop')->getFieldByWebid($webid,'id');
        if(!$ads_num){
            echo json_encode(array('id'=>true));exit;
        }
        $arr = array();
        $length = count($id);
        $return = array();
        for($i=0;$i<$length;$i++){
            $return[$i] = array('id'=>$id[$i]);
        }
        echo json_encode($return);exit;
    }
    public function delBook(){
        $web = $this->getWebId();
        $webid = (int)$web['id'];
        $id = explode('.', $this->updApi(ACTION_NAME));
        $ads_num =M('book')->getFieldByWebid($webid,'id');
        if(!$ads_num){
            echo json_encode(array('id'=>true));exit;
        }
        $arr = array();
        $length = count($id);
        $return = array();
        for($i=0;$i<$length;$i++){
            $return[$i] = array('id'=>$id[$i]);
        }
        echo json_encode($return);exit;
    }
    public function delNews(){
        $web = $this->getWebId();
        $webid = (int)$web['id'];
        $id = explode('.', $this->updApi(ACTION_NAME));
        $ads_num = M('news')->getFieldByWebid($webid,'id');
        if(!$ads_num){
            echo json_encode(array('id'=>true));exit;
        }
        $arr = array();
        $length = count($id);
        $return = array();
        for($i=0;$i<$length;$i++){
            $return[$i] = array('id'=>$id[$i]);
        }
        echo json_encode($return);exit;
    }
    public function delVadio(){
        $web = $this->getWebId();
        $webid = (int)$web['id'];
        $id = explode('.', $this->updApi(ACTION_NAME));
        $ads_num = M('vadio')->getFieldByWebid($webid,'id');
        if(!$ads_num){
            echo json_encode(array('id'=>true));exit;
        }
        $arr = array();
        $length = count($id);
        $return = array();
        for($i=0;$i<$length;$i++){
            $return[$i] = array('id'=>$id[$i]);
        }
        echo json_encode($return);exit;
    }
    public function getCat()
    {
        $id = $this->updApi(ACTION_NAME);
        $cate = M('category')->where(array('cid'=>array('in',$id)))->select();

        echo $this->decodeUnicode(json_encode($cate));exit;
    }
    public function getAds()
    {
        $web = $this->getWebId();
        $id = $this->updApi(ACTION_NAME);
        if($id == 'all'){
            $where = array(
                'webid' => $web['id'],
            );
        }else{
            $where = array(
                'id' => array('in',$id)
            );
        }

        $Ads = M('ads')
            ->field('id,title as name,url as title,img as url,displayorder as "order",webid,position')
            ->where($where)->select();

        echo $this->decodeUnicode(json_encode($Ads));exit;
    }
    public function getProducts(){
        $web = $this->getWebId();
        $id = $this->byLimitPro(ACTION_NAME);
        if(stristr($id,'-')){
            $limit = explode('-',$id);
            $start = intval($limit[0]-1)*$limit[1];
            $end = $limit[1];
            $sql = 'SELECT p.*,c.cat_name,c.url FROM `rou_product` p LEFT JOIN `rou_category` c ON c.cid=p.cat_id   WHERE p
.`web_id`='.$web['id'].' LIMIT '.$start.','.$end;
        }else {
            $sql = 'SELECT p.*,c.cat_name,c.url FROM `rou_product` p LEFT JOIN `rou_category` c ON c.cid=p.cat_id   WHERE p.`id` in (' . $id . ')';
        }
        $pro = M()->query($sql);
        echo $this->decodeUnicode(json_encode($pro));exit;

    }
    public function editProduct(){
        $web = $this->getWebId();
        $id = $this->updApi(ACTION_NAME);
        $sql = 'SELECT p.*,c.cat_name,c.url FROM `rou_product` p LEFT JOIN `rou_category` c ON c.cid=p.cat_id  WHERE p.`id` in ('.$id.')';
        $pro = M()->query($sql);
        echo $this->decodeUnicode(json_encode($pro));exit;

    }
    public function getVadio(){
        $web = $this->getWebId();
        $id = $this->updApi(ACTION_NAME);

        $vadio = M('vadio')->field('v.*,c.cat_name,c.type1')
            ->alias('v')
            ->join('left join rou_category c ON C.cid=v.cat_id')
            ->where(array('v.id'=>array('in',$id)))->select();

        echo $this->decodeUnicode(json_encode($vadio));exit;
    }
    public function getWebId(){
        $where['ssid'] = I('get.ssid','');
        $where['gw_id'] = I('get.gw_id','');
        $webid = M('web_ap')->where($where)->getField('webid');

        if(empty($webid)){
            return false;
        }
        $web = M('website')->find($webid);
        return $web;

    }
    public function getApk(){
        $web = $this->getWebId();
        $id = $this->updApi(ACTION_NAME);
        if($id == 'all'){
            $sql = 'SELECT a.*,c.cat_name,c.type FROM `rou_apk` a LEFT JOIN `rou_category` c ON c.cid=a.cat_id WHERE a
.webid='.$web['id'];
        }else{
            $sql = 'SELECT a.*,c.cat_name,c.type FROM `rou_apk` a LEFT JOIN `rou_category` c ON c.cid=a.cat_id WHERE a.id in ('.$id.')';
        }
        $apk = M()->query($sql);
        foreach($apk as &$value)
        {

            $map['type'] = 'apk';
            $map['desc'] = $value['id'];
            $value['images'] = array(
                array('idet'=>'no')
            );
            $value['desc'] = mysql_real_escape_string($value['desc']);
            unset($value);
        }

        echo $this->decodeUnicode(json_encode($apk));exit;
    }

    public function getMusic(){
        $web = $this->getWebId();
        $id = $this->updApi(ACTION_NAME);
        $music = M('music')->where(array('id'=>array('in',$id)))->select();
        echo $this->decodeUnicode(json_encode($music));exit;
    }
    public function getShop(){
        $web = $this->getWebId();
        $id = $this->updApi(ACTION_NAME);
        $music = M('shop')->where(array('id'=>array('in',$id)))->select();
        echo $this->decodeUnicode(json_encode($music));exit;
    }
    public function getBook(){
        $web = $this->getWebId();
        $id = $this->updApi(ACTION_NAME);
        $music = M('book')->where(array('id'=>array('in',$id)))->select();
        echo $this->decodeUnicode(json_encode($music));exit;
    }
    public function getNews(){
        $web = $this->getWebId();
        $id = $this->updApi(ACTION_NAME);

        if($id=='all'){
            $sql = 'SELECT n.*,c.cat_name FROM `rou_news` n LEFT JOIN `rou_category` c ON c.cid=n.cat_id  WHERE c.webid ='.$web['id'];
        }else{
            $sql = 'SELECT n.*,c.cat_name FROM `rou_news` n LEFT JOIN `rou_category` c ON c.cid=n.cat_id  WHERE n.id in ('.$id.')';
        }
        echo $sql;
        $news = M()->query($sql);
        $path = './Down/';
        $filename = uniqid();
        $hd = fopen($path.$filename,'a');
        fwrite($hd,$this->decodeUnicode(json_encode($news)));
        fclose($hd);
        $this->downFile($path,$filename);
    }

    /**
     * 模板下载
     */
    public function downTpl(){
        $web = $this->getWebId();
        $this->updApi(ACTION_NAME);
        if(!$web){
            die('error');
        }

        if(strstr($web['filename'],'.zip')){

            $arr = explode('/',$web['filename']);
            $count = count($arr);
            $filename = $arr[$count-1];
            unset( $arr[$count-1]);
            $path = implode('/',$arr);
            self::downFile(WEB_ROOT.$path.'/',$filename);exit;
        }
        $tplName = $web['tpl_style'];
        if(file_exists(WEB_ROOT.'/MediaTpl/'.$tplName.'/islua.flag')){

            $path = WEB_ROOT.'/MediaTpl/'.$tplName.'/';
            $tplName = $tplName.'.zip';
            self::downFile($path, $tplName);exit;
        }else{

            if(file_exists(WEB_ROOT.'/'.$web['filename'].'/'.$web['tpl_style'].'.zip')) unlink(WEB_ROOT.'/'.$web['filename'].'/'.$web['tpl_style'].'.zip');
            $Zip = new \Think\PHPZip();
            $Zip->Zip(WEB_ROOT.$web['filename'],WEB_ROOT.'/'.$web['filename'].'/'.$web['tpl_style'].'.zip');
            self::downFile(WEB_ROOT.'/'.$web['filename'].'/', $web['tpl_style'].'.zip');exit;
        }
    }
    protected function downFile($path,$file_name){
        header("Content-type:text/html;charset=utf-8");

        $file_name = iconv("utf-8", "gb2312", $file_name);
        $file_sub_path = $path;
        $file_path = $file_sub_path . $file_name;

        if(!file_exists($file_path)){
            echo '文件不存在';
            return ;
        }
        $fp=fopen($file_path,"r");
        $file_size=filesize($file_path);
        Header("Content-type: application/octet-stream");
        Header("Accept-Ranges: bytes");
        Header("Accept-Length:".$file_size);
        Header("Content-Disposition: attachment; filename=".$file_name);
        $buffer=1024;
        $file_count=0;
        while(!feof($fp) && $file_count<$file_size){
            $file_con=fread($fp,$buffer);
            $file_count+=$buffer;
            echo $file_con;
        }
        fclose($fp);
    }
    public function decodeUnicode($str)
    {
        return preg_replace_callback('/\\\\u([0-9a-f]{4})/i',
            create_function(
                '$matches',
                'return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");'
            ),
            $str);
    }

    protected function byLimitPro()
    {
        $where['gw_id'] = I('get.gw_id','');
        $where['ssid'] = I('get.ssid','');
        $apiid = M('web_ap')->where($where)->getField('id');

        $influ_id = M('webapi')->where(array(
            'webid' => $apiid,
            'api' => I('get.action')
        ))
            ->field('id,influ_ids')
            ->find();

        $upd['influ_ids'] = '';
        $upd['state'] = '0';
        $upd['id'] = $influ_id['id'];

        if(stristr($influ_id['influ_ids'],'-')){
            $arr = explode('-',$influ_id['influ_ids']);
            if($arr[0] != 1) {
                $upd['influ_ids'] = intval($arr[0]) - 1;
                $upd['influ_ids'] .= '-' . $arr[1];
                $upd['state'] = '1';
            }
        }

        M('webapi')->save($upd);
        return $influ_id['influ_ids'];

    }

}
?>
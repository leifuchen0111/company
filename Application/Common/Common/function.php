<?php 
    //将秒转换成时分秒
    function str_time($strtime){

        $strtime = abs($strtime);

        $h = floor($strtime/3600);
        $i = floor(($strtime-$h*3600)/60);
        $s = $strtime-$h*3600-$i*60;
        return($h.'小时'.$i.'分'.$s.'秒');
    }
    
    //将小数转化为百分比
    
    function float_to_percent($float){
        
        return (string)($float*100).'%';
        
    }
    
    function byt_to_m($p){
        
        return $p/1000000;
        
    }
    
    /**
     * 获取路由器硬件序列号
     */
    function getHwserail($rmac){
        $Ap = M('ap_main');
        $ap = $Ap->field('hwserial')->getByGw_id($rmac);
        return $ap['hwserial'];
    }
    function json($msg,$result)
    {
        echo json_encode(array('status'=>$result,'msg'=>$msg));
        exit();
    }
function updateApi($webid,$api,$id)
{
    C('DB_PREFIX','rou_');
    $Api = D('webapi');
    $Webap = M('web_ap');
    $map = array();
    $map['webid'] = $webid;
    $web_ap = $Webap->where($map)->field('id')->select();

    foreach($web_ap as $item){
        $webap = $item['id'];

        $map['api'] = $api;
        $map['webid'] = $webap;

        $data = $Api->where($map)->find();

        if(empty($data)){
            $Api->create($map);
            $apiid = $Api->add();
            $data = $map;
            $data['id'] = $apiid;
        }

        $Api->create($data);

        $influ_ids = empty($Api->influ_ids)?$id:$Api->influ_ids.','.$id;
        $Api->influ_ids = implode(',',array_unique(explode(',',$influ_ids)));
        $Api->state = '1';
        $result = $Api->save();

    }

    return $result?true:false;
}
function cancleApi()
{
    C('DB_PREFIX','rou_');
    $Webap = M('web_ap');
    $Api = M('webapi');
    $action = I('get.action','');

    $api_webid = $Webap->where($_GET)->getField('id');
    $map = array();
    $map['api'] = $action;
    $map['webid'] = $api_webid;
    $data['state'] = '0';
    $data['influ_ids'] = '';

    $Api->where($map)->data($data)->save();


}

function copyDir($src,$dst) {  // 原目录，复制到的目录

$dir = opendir($src);
@mkdir($dst);
while(false !== ( $file = readdir($dir)) ) {
    if (( $file != '.' ) && ( $file != '..' )) {
        if ( is_dir($src . '/' . $file) ) {
            copyDir($src . '/' . $file,$dst . '/' . $file);
        }
        else {
            copy($src . '/' . $file,$dst . '/' . $file);
        }
    }
}
closedir($dir);
}

function _isExsist($map,$Model){

    if($Model->where($map)->find()){

        return true;
    }else{
        return false;
    }
}

function decodeUnicode($str,$zy = true)
{
    $str = preg_replace_callback('/\\\\u([0-9a-f]{4})/i',
        create_function(
            '$matches',
            'return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");'
        ),
        $str);

    if($zy) {
        $str = stripslashes($str);
        $str = html_entity_decode($str);
      

    }
    return $str;
}
?>
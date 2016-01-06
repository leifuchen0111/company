<?php
//生成热点配置文件
function setSsdiConfFile($gw){
    $Ssid = M('ssid');
    $data['gw_id'] = array('in', $gw . ',' . session('userId') . '_c');
    $ssidList = $Ssid->where($data)->select();
    $path_wireless = './RouteConf_File/' . $gw . '/';
    if (!is_dir($path_wireless)) {
        mkdir($path_wireless);
    }
    $hd = fopen($path_wireless . 'wireless.conf', 'w');
    foreach ($ssidList as $item) {
        fwrite($hd, 'freq=' . $item['channel'] . ' ssid="' . $item['ssid'] . '" pwd="' . $item['psd'] . '"' . "\r\n");
    }
    $channel = M('apconf')->where(array('gw_id' => $gw))->field('2c,5c')->find();
    fwrite($hd, 'channel2="' . $channel['2c'] . '"' . "\r\n");
    fwrite($hd, 'channel5="' . $channel['5c'] . '"' . '');
    fclose($hd);
}
function getSsid($gw){

    $data['getssid'] = '1';
    $map['gw_id'] = $gw;
    $result = M('ap_main')->where($map)->save($data);
    if($result){
        return true;
    }else{
        return false;
    }
}

/**
 * @example 删除文件夹及所有自文件夹、文件
 */
function deldir($dir)
{
    //先删除目录下的文件：
    $dh = @opendir($dir);
    while ($file = @readdir($dh)) {
        if ($file != '.' && $file != '..') {
            $fullpath = $dir . '/' . $file;
            !is_dir($fullpath) ? @unlink($fullpath) : deldir($fullpath);
        }
    }
    closedir($dh);
    //删除当前文件夹：
    return rmdir($dir) ? true : false;
}
/*获取模板信息*/
function getTpl(){
    $path = realpath($_SERVER['DOCUMENT_ROOT'] . '/MediaTpl/');
    $path = str_replace('\\', '/', $path);
    $tpldir = scandir($path);
    $count = count($tpldir);
    $arr = array();
    $j = 0;
    //获取模板信息，一排显示4个
    for ($i = 0; $i < $count; $i++) {
        if (preg_match('/\.+/',$tpldir[$i]) != 0) {
            continue;
        }
        if (is_dir($path . '/' . $tpldir[$i])) {
            $key = floor($j / 4);
            $arr[$key][] = array(
                'tpl_name' => $tpldir[$i],
                'screenshot' => '/MediaTpl' . '/' . $tpldir[$i] . '/screenshot.jpg',
                'intro' => file_get_contents('./MediaTpl' . '/' . $tpldir[$i] . '/readme.txt')
                );
        }
        $j++;
    }

    return $arr;
}

function tostring($str){

    $str = preg_replace('/[^\d\w]/','',$str);
    return strtoupper($str);
}
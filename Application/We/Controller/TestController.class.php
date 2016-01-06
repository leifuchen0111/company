<?php 
namespace We\Controller;
use Think\Controller;
class TestController extends Controller{
    
    public function index(){
        $filename = 'amanda20150428152319273';
        $insertId = 56;
        $data['filename'] = '/Down/'.session('name').'/'.$filename;

        $arr = scandir(WEB_ROOT.$data['filename']);
        $count = count($arr);
        for($i=0;$i<$count;$i++){
        
            if(preg_match('/^[0-9a-zA-Z_]+\.php/',$arr[$i])){
        
                $hd = fopen(WEB_ROOT.$data['filename'].'/'.substr($arr[$i],0,-4).'.html','w');
            //    echo 'http://'.$_SERVER['HTTP_HOST'].$data['filename'].'/'.$arr[$i].'?webid='.$insertId.'<br />';
                $content = file_get_contents('http://'.$_SERVER['HTTP_HOST'].$data['filename'].'/'.$arr[$i].'?webid='.$insertId);
                fwrite($hd,$content);
                fclose($hd);
            }
        }
    }
}
?>
<?php
namespace Train\Controller;
use Think\Controller;
class ApiController extends Controller{


    public function getCategory(){
        $Cate = D('category');
        $Article = D('article');

        $map['pid'] = 1;
        $type = C('TYPE1');
        $cates = $Cate->where($map)->select();

        foreach($cates as $v){

            $dir = './MediaTpl/Train/train/';

            $dir .= $type[$v['name']]?$type[$v['name']]:$v['name'];
            //$dir = iconv('utf-8','gbk',$dir);
            if(!is_dir($dir)) mkdir($dir,0777,true);

            $map['pid'] = $v['id'];
            $data = $Cate->field('name,id')->where($map)->select();

            $map = array();
            $map['category'] = $v['id'];
            $map['show'] = '1';
            $article = $Article
                ->field('id,title,about,image,media,show,attachment,update_time,content')
                ->where($map)
                ->order('id desc')
                ->select();

            if($article) {
                $hd = fopen($dir . '/list', 'w+');
                fwrite($hd, $this->decodeUnicode(json_encode($article)));
                fclose($hd);
            }

            foreach($data as $item){

                //$item['name'] = iconv('utf-8','gbk',$item['name']);
                $dir1 = $dir.'/'.$item['name'];

                if(!is_dir($dir1)) mkdir($dir1,0777,true);

                $map = array();
                $map['category'] = $item['id'];
                $map['show'] = '1';
                $article = $Article->field('id,title,about,image,media,show,attachment,update_time,content')->where($map)->select();


                $article = $this->decodeUnicode(json_encode($article));
                if($article) {
                    $hd = fopen($dir1 . '/list', 'w+');
                    fwrite($hd, $article);
                    fclose($hd);
                }
                updateApi(1,'downData','');

            }

        }

    }

    public function decodeUnicode($str)
    {

        $str = str_replace('\t','',$str);
        $str = str_replace('\r','',$str);
        $str = str_replace('\n','',$str);
        $str = str_replace('\/','/',$str);
        $str = str_replace('\"','"',$str);
        $str = str_replace('\'','',$str);

        return preg_replace_callback('/\\\\u([0-9a-f]{4})/i',
            create_function(
                '$matches',
                'return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");'
            ),
            $str);
    }
    //提供统计数据下载
    public function getData(){

        $time = I('get.time');
        if(!$time){
            $time = date('Y-m-d',time());
        }
        $path = './Uploads/Train/data/'.$time.'/';
        if(!is_dir($path)){
            exit('no data');
        }
        $Zip = new \Think\PHPZip();
        $Zip->Zip($path,$path.$time.'.zip');
        self::downFile($path,$time.'.zip');
        unlink($path.$time.'.zip');exit;

    }

    //提供统计数据下载
    public function get2Data(){

        $time = I('get.time');
        if(!$time){
            $time = date('Y-m-d',time());
        }
        $path = './Uploads/Train/data2/'.$time.'/';
        if(!is_dir($path)){
            exit('no data');
        }
        $Zip = new \Think\PHPZip();
        $Zip->Zip($path,$path.$time.'.zip');
        self::downFile($path,$time.'.zip');
        unlink($path.$time.'.zip');exit;

    }


    public function downData(){
        cancleApi();
        echo U('Train/Api/down');

    }

    public function down(){

        $Zip = new \Think\PHPZip();
        $Zip->Zip('./MediaTpl/Train/train/','./MediaTpl/Train/train/data.zip');
        $this->downFile('./MediaTpl/Train/train/','data.zip');
        unlink('./MediaTpl/Train/train/data.zip');
        exit;

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
        return;
    }

    public function getAds(){
        C('DB_PREFIX','rou_');
        $Webap = M('web_ap');
        $Api = M('webapi');
        $api_webid = $Webap->where($_GET)->getField('id');

        $map['webid'] = $api_webid;
        $map['api'] = 'getAds';

        $ids = $Api->where($map)->getField('influ_ids');

        $Ads = M('ads');
        $map = array();
        $map['id'] = array('in',$ids);
        $data = $Ads
            ->where($map)
            ->order('displayorder desc')
            ->select();

        cancleApi();
        exit(json_encode($data));
    }

}
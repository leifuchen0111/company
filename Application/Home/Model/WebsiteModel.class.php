<?php 
namespace Home\Model;
use Think\Model;
/**
 * 自媒体站点模型
 */
class WebsiteModel extends Model{

    public function websdelete($webid)
    {
        $map = array();
        $map['id'] = array('in',$webid);
        $files = $this->field('filename')->where($map)->select();
        $this->deleteFiels($files);
        if($this->where($map)->delete()){
            return true;
        }else{
            return false;
        }

    }

    protected function deleteFiels($files){

        foreach($files as $item){
            if(strlen($item['filename']) > 5) {
                deldir(WEB_ROOT . $item['filename']);
            }
        }

    }

    protected function delWebData($webid){

        //删除分类
        $map = array();
        $map['webid'] = array('in',$webid);
        M('category')->where($map)->delete();
        //删除广告
        M('ads')->where($map)->delete();
        //删除APK
        M('apk')->where($map)->delete();
        //删除文章
        M('article')->where($map)->delete();
        //删除相关图片
        M('images')->where($map)->delete();
        //删除音乐
        M('music')->where($map)->delete();
        //删除新闻
        M('news')->where($map)->delete();
        //删除商品
        M('product')->where($map)->delete();
        //删除商品图片
        M('pro_img')->where($map)->delete();

    }

}
?>
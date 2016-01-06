<?php
/**
 * Created by PhpStorm.
 * User: lfc
 * Date: 2015/11/26
 * Time: 18:00
 */

namespace Catering\Controller;


class NewsController extends BaseController
{
    public function news()
    {
        $News = M('news');
        $map = array();

        $map['webid'] = I('get.webid',0);
        $list = $News->where($map)->order('displayorder asc')->select();

        $this->list = $list;
        $this->display();

    }

    public function add()
    {
        $Cate = M('category');
        C('DB_PREFIX','rou_');
        $Website = M('website');
        $webid = I('get.webid',0);

        $map = array();
        $map['type'] = 'news';
        $map['webid'] = $webid;
        $cates = $Cate->where($map)->select();

        if(!$cates){
            $this->error('请先添加新闻分类',U('CatePro/add',array('type'=>'news','webid'=>$webid,'gw_id'=>I('get.gw_id',''))));
        }

        $uplodPath = $Website->getFieldByid($webid,'filename');

        $this->cates = $cates;
        $this->uplodPath = urlencode(str_replace('/','.',$uplodPath.'/reource'));;
        $this->display();
    }

    public function edit(){

        $Cate = M('category');
        $id = I('get.id',0);
        $webid = I('get.webid',0);

        $news = M('news')->find($id);

        $map = array();
        $map['type'] = 'news';
        $map['webid'] = $webid;
        $cates = $Cate->where($map)->select();

        $this->cates = $cates;
        $this->news = $news;
        $this->display('add');
    }

    public function save()
    {
        $News = D('news');
        $data = $News->create();

        if(!$data){

            $this->error($News->getError());
        }

        if($News->id){
            //修改
            if($News->save()){

                updateApi($data['webid'],'updNews',$data['id']);
                $this->success('修改成功');
            }else{
                $this->error('修改失败');
            }

        }else{
            //新增

            if($News->add()){

                updateApi($data['webid'],'getNews',$News->getLastInsId());
                $this->success('添加成功');
            }else{

                $this->error('添加失败');
            }

        }


    }

}
<?php
/**
 * Created by PhpStorm.
 * User: lfc
 * Date: 2015/11/26
 * Time: 18:00
 */

namespace Train\Controller;


class AdsController extends BaseController
{
    public function ads()
    {
        $Ads = M('Ads');
        $map = array();

        $map['webid'] = I('get.webid',0);
        $list = $Ads->where($map)->order('displayorder asc')->select();

        $this->list = $list;
        $this->display();

    }

    public function add()
    {
        C('DB_PREFIX','rou_');
        $Website = M('website');
        $webid = I('get.webid',0);

        $uplodPath = $Website->getFieldByid($webid,'filename');

        $this->uplodPath = urlencode(str_replace('/','.',$uplodPath.'/reource'));;
        $this->display();
    }

    public function edit(){

        $id = I('get.id',0);
        $ad = M('ads')->find($id);

        $this->ad = $ad;

        $this->display('add');
    }

    public function adsDel()
    {
        $Ads = M('ads');
        $id = I('get.id','');
        $map = array(
          'id' => array('in',$id)
        );
        $ad = $Ads->where($map)->find();
        $webid = $ad['webid'];

        $result = $Ads->where($map)->delete();
        if($result){
            updateApi($webid,'delAds',$id);
            $this->ajaxReturn(array('state'=>0,'msg'=>'删除成功'));
        }else{
            $this->ajaxReturn(array('state'=>1,'msg'=>'删除失败'));
        }

    }

    public function save()
    {
        $Ads = D('ads');
        $_validate = array(
            array('img','require','请上传图片')
        );
        $data = $Ads->validate($_validate)->create();
        if(!$data){
            $this->error($Ads->getError());
        }

        if(!$Ads->id){
            if($Ads->add()){
                updateApi($data['webid'],'getAds',$Ads->getLastInsId());
                $this->success('添加成功');

            }else{
                $this->error('添加失败');
            }
        }else{
            if($Ads->save()){
                updateApi($data['webid'],'getAds',$data['id']);
                $this->success('修改成功');

            }else{
                $this->error('修改失败');
            }
        }


    }

}
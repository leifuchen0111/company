<?php
namespace Singlepage\Controller;

class ArtController extends BaseController
{

    public function art(){

        $Art = M('art');
        $webid = I('get.webid',0);
        $map = array();

        $map['webid'] = $webid;
        $art = $Art->where($map)->find();

        $this->art = $art;
        $this->display();


    }

    public function save(){

        $Art = D('art');

        $data = $Art->create();

        if($Art->id){
            //编辑
            if($Art->save()){

                updateApi($data['webid'],'getContent',$data['id']);
                $this->success('内容编辑成功');

            }else{
                $this->error('内容编辑失败');
            }
        }else{
            //添加
            if($Art->add()){
                updateApi($data['webid'],'getContent',$Art->getLastInsId());
                $this->success('内容编辑成功');

            }else{
                $this->error('内容编辑失败');
            }

        }



    }
}
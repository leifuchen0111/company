<?php
/**
 * Created by PhpStorm.
 * User: lfc
 * Date: 2015/11/27
 * Time: 12:22
 */

namespace Singlepage\Controller;


class LinkController extends BaseController
{

    public function link()
    {
        $Link = M('link');
        $map = array();
        $webid = I('get.webid',0);

        $map['webid'] = $webid;
        $link = $Link->where($map)->find();

        $this->link = $link;
        $this->display();
    }

    public function save()
    {

        $Link = D('link');
        $data = $Link->create();

        if($Link->type == 'file' && $_FILES['android']['error'] != 4){
            C('DB_PREFIX','rou_');
            $savePath = M('website')->getFieldByid($Link->webid,'filename');

            $config = array(
                'exts' => 'apk',
                'rootPath' => '.'.$savePath.'/resources/'
            );

            $Upload = new \Think\Upload($config);

            $info = $Upload->uploadOne($_FILES['android']);
            if($Upload->getError()){
                $this->error($Upload->getError());
            }

            $Link->android = $savePath.'/resources/'.$info['savepath'].$info['savename'];

        }

        if($Link->id){
            //修改
            if($Link->save()){
                updateApi($data['webid'],'getLink',$data['id']);
                $this->success('链接修改成功');


            }else{

                $this->error('链接修改失败');
            }
        }else{
            //添加
            if($Link->add()){
                updateApi($data['webid'],'getLink',$Link->getLastInsId());
                $this->success('链接修改成功');

            }else{
                $this->error('链接修改失败');
            }
        }


    }

}
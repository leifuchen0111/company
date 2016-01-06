<?php
/**
 * Created by PhpStorm.
 * User: lfc
 * Date: 2015/11/27
 * Time: 15:41
 */

namespace Singlepage\Controller;


class ApiController extends BaseController
{
    public function getAds(){
        C('DB_PREFIX','rou_');
        $Webap = M('web_ap');
        $Api = M('webapi');
        $api_webid = $Webap->where($_GET)->getField('id');

        $map['webid'] = $api_webid;
        $map['api'] = 'getAds';

        $ids = $Api->where($map)->getField('influ_ids');

        C('DB_PREFIX','rou_singlepage_');
        $Ads = M('ads');
        $map = array();
        $map['id'] = array('in',$ids);
        $data = $Ads
            ->where($map)
            ->order('displayorder desc')
            ->field('id,img,displayorder,link')
            ->select();
        cancleApi();
        exit(json_encode($data));
    }

    public function getLink(){
        $Webap = M('web_ap');
        $webid = $Webap->where($_GET)->getField('webid');

        C('DB_PREFIX','rou_singlepage_');
        $Link = M('link');
        $data = $Link->field('android,type,ios')->getByWebid($webid);
        cancleApi();
        exit(json_encode($data));
    }

    public function getContent(){

        $Webap = M('web_ap');
        $webid = $Webap->where($_GET)->getField('webid');
        C('DB_PREFIX','rou_singlepage_');
        $Art = M('Art');
        $data = $Art->field('content')->getByWebid($webid);
        cancleApi();
        exit(decodeUnicode(json_encode($data)));
    }

    public function getBaseConf(){

        $Webap = M('web_ap');
        $Website = M('website');
        $webid = $Webap->where($_GET)->getField('webid');

        $data = $Website->find($webid);

        cancleApi();
        exit(html_entity_decode(decodeUnicode(json_encode($data),false)));


    }
}

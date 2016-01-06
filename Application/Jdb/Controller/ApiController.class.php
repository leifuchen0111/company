<?php
/**
 * Created by PhpStorm.
 * User: lfc
 * Date: 2015/11/27
 * Time: 15:41
 */

namespace Jdb\Controller;


use Think\Controller;

class ApiController extends Controller
{
    public function getBaseConf(){

        $Webap = M('web_ap');
        $Website = M('website');
        $webid = $Webap->where($_GET)->getField('webid');

        $data = $Website->find($webid);

        cancleApi();
        exit(html_entity_decode(decodeUnicode(json_encode($data),false)));


    }
}

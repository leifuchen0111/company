<?php
/**
 * Created by PhpStorm.
 * User: lfc
 * Date: 2015/12/11
 * Time: 17:35
 */

namespace Catering\Controller;


class ApiController
{
    public function getBaseConf()
    {

        $Webap = M('web_ap');
        $webid = $Webap->where($_GET)->getField('webid');
        $web = M('website')->find($webid);
        cancleApi();
        exit(decodeUnicode(json_encode($web)));
    }
}
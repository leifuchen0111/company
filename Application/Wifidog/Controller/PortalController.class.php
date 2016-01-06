<?php 
namespace Wifidog\Controller;
use Think\Controller;
class PortalController extends Controller{
    
    public function index(){
        header('content-type:text/html;charset=utf-8');
        echo '恭喜您，认证成功<a href="http://www.sun-net.cn">普运技术</a>';
    }
}

?>
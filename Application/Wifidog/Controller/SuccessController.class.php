<?php 
namespace Wifidog\Controller;
use Think\Controller;
class SuccessController extends Controller{
    public function index(){
        echo '<h1>恭喜您，认证成功</h1>';
    }
}
?>
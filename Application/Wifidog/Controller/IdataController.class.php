<?php
namespace Wifidog\Controller;
use Think\Controller;
class IdataController extends Controller{
    public function iData()
    {
        $config = array(
            'rootPath' => './Uploads/Train/data/',
            'exts' => '',
            'saveName' => $_FILES['fw']['name'].'_'.time().'_'.uniqid()
        );
        $Upload = new \Think\Upload($config);
        $Upload->uploadOne($_FILES['fw']);

        if ($Upload->getError()) {
            echo $Upload->getError();
            exit('false');
        }

        exit('true');

    }

    public function i2Data()
    {
        $config = array(
            'rootPath' => './Uploads/Train/data2/',
            'exts' => '',
            'saveName' => $_FILES['fw']['name'].'_'.time().'_'.uniqid()
        );
        $Upload = new \Think\Upload($config);
        $Upload->uploadOne($_FILES['fw']);

        if ($Upload->getError()) {
            echo $Upload->getError();
            exit('false');
        }

        exit('true');

    }

    public function eData(){
        layout(false);
        $this->display();

    }

}
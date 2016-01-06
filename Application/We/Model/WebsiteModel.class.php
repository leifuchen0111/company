<?php 
namespace We\Model;
use Think\Model;
class WebsiteModel extends Model{
    protected $_map = array(
        'tpl_style' => '',
        'filename' => 'logo',
        'title' => 'web_name'
    );
    protected $_auto = array(
        array('logo','getLogoUrl',2,'callback'),

    );
    public function getLogoUrl()
    {
        return I('post.path').I('post.filename');
    }
}
?>
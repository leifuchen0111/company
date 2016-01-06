<?php
/**
 * Created by PhpStorm.
 * User: lfc
 * Date: 2015/12/14
 * Time: 17:16
 */

namespace Catering\Model;


use Think\Model;

class NewsModel extends Model
{
    protected $_validate = array(

        array('title','require','请输入新闻标题'),
        array('author','require','请输入作者'),
        array('category','require','请选择分类'),
    );

    protected $_auto = array(
        array('posttime','time',1,'function')
    );
}
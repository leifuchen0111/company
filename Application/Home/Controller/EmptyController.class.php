<?php
/**
 * 404错误
 */
namespace Home\Controller;

use Think\Controller;
class EmptyController extends Controller
{
    public function _empty()
    {
        R('Tool/Tool/show404');
    }
    public function index()
    {
        $this->_empty();
    }
}
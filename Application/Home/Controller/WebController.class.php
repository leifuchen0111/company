<?php
/**
 * 自媒体建站模块
 * @author bpm
 *
 */
namespace Home\Controller;

use Think\Controller;
class WebController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        R('Tool/Tool/checkLogin');
    }
    public function buildweb()
    {
    }
    /**
     * 404
     */
    public function _empty()
    {
        R('Tool/Tool/show404');
    }
}
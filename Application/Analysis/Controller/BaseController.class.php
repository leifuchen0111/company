<?php
/**
 * Created by PhpStorm.
 * User: lfc
 * Date: 2015/12/21
 * Time: 9:35
 */

namespace Analysis\Controller;


use Think\Controller;

class BaseController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        R('Tool/Too/chechLogin');

        R('Home/Public/showHeader');
        R('Home/Public/showFooter');

    }
}
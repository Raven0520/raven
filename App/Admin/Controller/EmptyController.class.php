<?php
namespace Admin\Controller;
use Common\Controller\CommonController;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/22
 * Time: 12:42
 */

class EmptyController extends CommonController
{
    public function _empty(){

        $this->display(ACTION_NAME);
    }
}
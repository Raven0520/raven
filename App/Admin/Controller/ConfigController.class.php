<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/11
 * Time: 14:11
 */

namespace Admin\Controller;


class ConfigController extends EmptyController
{
    public function getList($sign=null){
        $this->where['sign'] = $sign;
        $this->ajaxReturn($this->select(CONTROLLER_NAME,$this->where));
    }
}
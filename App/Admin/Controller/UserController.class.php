<?php
/**
 * Created by PhpStorm.
 * User: raven
 * Date: 2016/12/29
 * Time: 22:58
 */

namespace Admin\Controller;


class UserController extends EmptyController
{
    public function _before_index(){
        $group = $this->select('AuthGroup','status=1','id,title','id');
        $this->assign('group',$group);
    }
}
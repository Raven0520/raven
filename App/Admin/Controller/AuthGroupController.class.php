<?php
/**
 * Created by PhpStorm.
 * User: raven
 * Date: 2016/12/29
 * Time: 21:05
 */

namespace Admin\Controller;


class AuthGroupController extends EmptyController
{
    public function _before_index(){
        $menu_list = M('AuthRule')->where(array('menu_type'=>1,'menu_status'=>1))->getField('id',true);
        $menu_list = json_encode($menu_list);
        $this->assign('menu_list',$menu_list);
    }
}
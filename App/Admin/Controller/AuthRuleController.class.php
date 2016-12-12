<?php
/**
 * Created by PhpStorm.
 * User: raven
 * Date: 2016/12/5
 * Time: 23:36
 */

namespace Admin\Controller;


class AuthRuleController extends EmptyController
{
    public function index()
    {
        $this->where['sort_id'] = 0;
        $menu = $this->select(CONTROLLER_NAME,$this->where);
        foreach ($menu as $k => $v){
            $name = 'sec' . $menu[$k]['id'];
            $menu[$k]['second'] = $name;
            $this->where['sort_id'] = $menu[$k]['id'];
            $data = $this->select(CONTROLLER_NAME,$this->where);
            $this->assign($name,$data);
        }
        $this->assign('menu',$menu);
        $this->display();
    }

    /**
     * 获取二级菜单
     */
    public function getSecMenu($sort_id){
        $this->where['sort_id'] = $sort_id;
        $sec = $this->select(CONTROLLER_NAME,$this->where);
//        dump($sec);
        $this->ajaxReturn($sec);
    }
}
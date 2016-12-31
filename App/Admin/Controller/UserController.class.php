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

    public function Login($username,$password){
        $res = M(CONTROLLER_NAME)->where(array('username'=>$username))->field('id,nickname,tel,password,status')->find();
        $this->res['status'] = 0;
        if (empty($res)){
            $this->res['info'] = '用户名不存在';
            $this->ajaxReturn($this->res);
        }
        if (0 == $res['status']){
            $this->res['info'] = '用户被禁用';
            $this->ajaxReturn($this->res);
        }

        $password = getMD5($password);
        if ($password != $res['password']){
            $this->res['info'] = '密码错误';
        }else {
            $this->res['status'] = 1;
            $this->res['info'] = '欢迎回来';
            unset($res['password']);
            session('user',$res);
        }
        $this->ajaxReturn($this->res);
    }
}
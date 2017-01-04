<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/22
 * Time: 12:47
 */

namespace Admin\Controller;

use Think\Controller;

class LoginController extends Controller
{
    protected $res = array('status'=>1,'info'=>'操作成功');

    public function index(){
        $this->display();
    }

    public function Login($username,$password){
        $res = M('user')->where(array('username'=>$username))->field('id,nickname,tel,password,status')->find();
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
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
    protected $res = array('status' => 1, 'info' => '操作成功');

    public function index()
    {
        $user = session('user');
        if ($user && is_array($user)){
            redirect('/');
        }
        $this->display();
    }

    public function Login($username, $password)
    {
        $res = M('user')->where(array('username' => $username))->field('id,nickname,tel,password,status,login_time')->find();
        $this->res['status'] = 0;
        if (empty($res)) {
            $this->res['info'] = '用户名不存在';
            $this->ajaxReturn($this->res);
        }
        if (0 == $res['status']) {
            $this->res['info'] = '用户被禁用';
            $this->ajaxReturn($this->res);
        }

        $password = getMD5($password);
        if ($password != $res['password']) {
            $this->res['info'] = '密码错误';
        } else {
            $this->res['status'] = 1;
            $this->res['info'] = '欢迎回来';
            unset($res['password']);
            session('user', $res);
        }
        $this->ajaxReturn($this->res);
    }

    public function PermissionDenied(){
        $this->display();
    }

    /**
     * 录入用户登录信息
     */
    public function loginLog($id)
    {
        $data = array(
            'id'         => $id,
            'login_time' => time(),
            'login_ip'   => $this->getIp()
        );
        D('User')->update($data);
        $data['uid'] = $data['id'];
        unset($data['id']);
        M('login_log')->add($data);
    }

    /**
     * 获取用户IP的方法
     */
    public function getIp()
    {
        $ip = '';
        if (getenv("HTTP_CLIENT_IP")) {
            $ip = getenv("HTTP_CLIENT_IP");
        } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        } elseif (getenv("REMOTE_ADDR")) {
            $ip = getenv("REMOTE_ADDR");
        } else {
            $ip = 'UnKnow';
        }
        return $ip;
    }

    public function loginOut()
    {
        $user = session('user');
        $this->loginLog($user['id']);
        session('user', null);
        redirect('/login');
    }
}
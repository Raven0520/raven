<?php
/**
 * Created by PhpStorm.
 * User: raven
 * Date: 2016/12/29
 * Time: 23:12
 */

namespace Common\Model;

class UserModel extends CommonModel
{
    protected $_validate = array(
        array('username','','用户名已存在',0,'unique',1) //在新增的时候验证用户名是否唯一
    );

    public function _before_insert(&$data, $options)
    {
        $data['password'] = getMD5($data['password']);
    }
    public function _after_insert($data, $options)
    {
        $access['uid'] = $data['id'];
        $access['group_id'] = $data['group_id'];
        D('auth_group_access')->update($access);
    }

    public function _before_update(&$data, $options)
    {

        if (empty($data['password'])){
            unset($data['password']);
        }else {
            $data['password'] = getMD5($data['password']);
        }
        if ($data['group_id']){
            $access['uid'] = $options['where']['id'];
            $access['group_id'] = $data['group_id'];
            $res = M('auth_group_access')->where(array('uid'=>$access['uid']))->find();
            if ($res){
                $access['id'] = $res['id'];
            }

            D('auth_group_access')->update($access);
        }
    }
}
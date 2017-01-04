<?php
/**
 * Created by PhpStorm.
 * User: raven
 * Date: 2016/12/29
 * Time: 23:12
 */

namespace Admin\Model;
use Common\Model\CommonModel;

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
    }

    public function _after_update($data, $options)
    {
        $access['uid'] = $data['id'];
        $access['group_id'] = $data['group_id'];
        D('auth_group_access')->update($access);
    }
}
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
    public function _before_insert(&$data, $options)
    {
        $data['password'] = getMD5($data['password']);
    }

    public function _before_update(&$data, $options)
    {
        if (empty($data['password'])){
            unset($data['password']);
        }else {
            $data['password'] = getMD5($data['password']);
        }
    }
}
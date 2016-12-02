<?php
namespace Admin\Model;
use Common\Model\CommonModel;

/**
 * Created by PhpStorm.
 * User: raven
 * Date: 2016/12/1
 * Time: 05:19
 */
class AuthRuleModel extends CommonModel
{
    protected $_auto = array(
        array('create_time', NOW_TIME, 1,),
    );


}
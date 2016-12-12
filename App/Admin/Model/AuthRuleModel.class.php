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
        array('create_time', NOW_TIME, 1),
        array('update_time',NOW_TIME,2)
    );

    public function _after_select(&$result, $options)
    {
        foreach ($result as $k => $v){
            0 == $result[$k]['menu_type'] && $result[$k]['menu_type'] = 'Main Menu';
            1 == $result[$k]['menu_type'] && $result[$k]['menu_type'] = 'Sec Menu';
            2 == $result[$k]['menu_type'] && $result[$k]['menu_type'] = 'Win Menu';

            0 == $result[$k]['menu_status'] && $result[$k]['menu_status'] = 'Disable';
            1 == $result[$k]['menu_status'] && $result[$k]['menu_status'] = 'Active';
            -1 == $result[$k]['menu_status'] && $result[$k]['menu_status'] = 'Del';
            
        }
    }
}
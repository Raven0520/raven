<?php
/**
 * Created by PhpStorm.
 * User: raven
 * Date: 2016/12/1
 * Time: 04:46
 */

/**
 * 菜单类型的名称
 */
function MenuTypeName($menu_type){
    if ($menu_type == 0){
        return 'Main Menu';
    }
    if ($menu_type == 1){
        return 'Sec Menu';
    }
    if ($menu_type == 2){
        return 'Win Menu';
    }
}

/**
 * 获取状态名称
 */
function StatusName($status){
    if ($status == 1){
        return 'Active';
    }
    if ($status == 0){
        return 'Disabled';
    }
    if ($status == -1){
        return 'Del';
    }
}

/**
 * 获取状态样式
 */
function StatusClass($status){
    if ($status == 1){
        return 'status-metro status-active';
    }
    if ($status == 0){
        return 'status-metro status-suspended';
    }
    if ($status == -1){
        return 'status-metro status-disabled';
    }
}

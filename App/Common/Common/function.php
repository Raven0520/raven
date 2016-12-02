<?php
/**
 * Created by PhpStorm.
 * User: raven
 * Date: 2016/12/1
 * Time: 04:46
 */

/**
 * 公用的弹窗方法 返回控制器的执行结果
 */
function show($status,$message,$data = array()){
    $result = array(
        'status' => $status,
        'message' => $message,
        'data' => $data,
    );
    exit(json_encode($result));
}
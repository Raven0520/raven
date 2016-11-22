<?php
return array(
    //'配置项'=>'配置值'
    'URL_CASE_INSENSITIVE' => true,  //设置为true的时候表示URL地址不区分大小写
    'DEFAULT_MODULE' => 'Home', //默认模块
    //url访问模式为rewrite模式
    'URL_MODEL' => '1',
    //开启伪静态
//    'URL_HTML_SUFFIX' => '.html',
    //开启路由
//    'URL_ROUTER_ON' => true,
    //路由规则
//    'URL_ROUTE_RULES' => array(
//        'news/:id' => 'News/read',
//    ),

    // 加载扩展配置文件 多个用,隔开
    'LOAD_EXT_CONFIG' => 'db,view',
);
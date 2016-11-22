<?php
return array(
    //'配置项'=>'配置值'
    'URL_CASE_INSENSITIVE' => true,  //设置为true的时候表示URL地址不区分大小写

    //url访问模式为PathInfo模式
    'URL_MODEL' => '1',

    //域名部署
    'APP_SUB_DOMAIN_DEPLOY' => 1,
    'APP_SUB_DOMAIN_RULES' => array(
        'r.raven.com' => 'Admin',
        'raven.com'   => 'Home'
    ),

    //引用文件路径设置
    'TMPL_PARSE_STRING' => array(
        '__IMAGE__' => __ROOT__ . '/Public/images',
        '__CSS__' => __ROOT__ . '/Public/css',
        '__JS__' => __ROOT__ . '/Public/js',
        '__UPLOAD__' => __ROOT__ . '/Public/upload',
    ),

    // 加载扩展配置文件 多个用,隔开
    'LOAD_EXT_CONFIG' => 'db',

    //开启伪静态
//    'URL_HTML_SUFFIX' => '.html',
    //开启路由
//    'URL_ROUTER_ON' => true,
    //路由规则
//    'URL_ROUTE_RULES' => array(
//        'news/:id' => 'News/read',
//    ),
);
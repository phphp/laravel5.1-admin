<?php

return [
    // 后台名称
    'brand' => '控制台',

    // 用户列表分页尺寸
    'user_page_size' => 20,

    // 上传单文件大小，单位 KB，需要 php.ini 支持
    'upload_file_size' => 1024,

    // 测试用
    // 'XSQL' => null, // 所有执行的 sql 语句
    // 'CSQL' => 0, // sql 数量

    // 密码尺寸
    'password_min_length' => 6,
    'password_max_length' => 64,

    // 英文昵称尺寸
    'name_min_length' => 1,
    'name_max_length' => 15,

    // 中文昵称尺寸，也许要修改错误提示
    'zh_name_min_length' => 1,
    'zh_name_max_length' => 7,

    // 后台文章每页篇数
    'admin_post_size' => 30,

    // mime types: http://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types
    // 后台允许上传的文件类型
    'admin_upload_mimes' => 'image/jpeg,image/png,image/gif,text/plain,text/html,text/css,application/javascript,application/zip',
    // 前台 bootstrap file upload 组件允许的后缀（前端验证）
    'font_upload_extension' => 'jpg,png,gif,txt,log,conf,html,htm,css,js,md,zip',
];

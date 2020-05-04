<?php

$welcome = <<<EOT
|------------------------------------------|
|              欢迎使用 NewIDC             |
|          我将会帮您完成本次安装          |
|            请如实填写以下信息            |
|------------------------------------------|
EOT
;

return [
    'welcome'               => $welcome,
    'exist_tables'          => '检测到您的数据库不为空，继续安装可能会导致原有数据丢失，是否继续？',
    'env_not_exist'         => 'env文件不存在，请将.env.example复制一份并重命名为.env',
    'database_connect_fail' => '检测到数据库未连接成功，请先修改.env中数据库信息',
    'admin_config_tip'      => '即将设置超级管理员，该管理员具有完全的权限，请重点保管好此账号，并使用安全性较强的密码',
    'admin_username_tip'    => '超级管理员用户名',
    'admin_password_tip'    => '超级管理员密码',
    'success'               => '安装已完成，请打开 :url 验证是否安装成功',
    'exit'                  => '已退出安装',
    'password_empty'        => '密码为空，请重新输入',
    'recommend_webadmin'    => '推荐创建一个权限相对较小的网站管理员，具有通常的网站设置能力，适合日常使用，是否创建？',
    'webadmin_username_tip' => '超级管理员用户名',
    'webadmin_password_tip' => '超级管理员密码',
    'ready'                 => '基本配置已完成，是否开始安装？',
    'admin'                 => '超级管理员',
    'webadmin'              => '网站管理员',
    'error'                 => '发生错误： :message ，数据已回滚'
];

<?php

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG', false);
// 重新定义Runtime路径
define('RUNTIME_PATH', '/tmp/boaihui/Runtime/User/');

// 定义应用目录
define('APP_PATH', './User/');
// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';
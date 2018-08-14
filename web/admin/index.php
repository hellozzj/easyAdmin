<?php
/**
 * 入口文件
 * @author unchastity
 * @since 2015.08.31
 */
namespace admin;
use app\lib\app;

defined('ROOT_BASE_DIR') OR define('ROOT_BASE_DIR',__DIR__.'/../');
// 引入启动文件
include '../../public/boot.php';
// 每个请求最长允许运行5分钟
set_time_limit(300);
// 启用session
session_start();
// 运行应用
app::run();
// \api\Lib\App::run();

<?php
/**
 * 启动文件
 * @author unchastity
 * @since 2015.08.31
 */

include '../../app/header.php';
set_include_path(
    LIB_DIR.'exception'
    .PATH_SEPARATOR. get_include_path()
);



// 时区设置
// date_default_timezone_set($config->get('timezone'));

// 设置session文件的失效时间，默认为1小时
ini_set("session.gc_maxlifetime", 3600);
// session文件清除机率，默认为20%，访问量大的网站可以设小一些
ini_set('session.gc_probability', 20);
// session保存到特定目录
session_save_path(VAR_DIR.'/sess');
header('Cache-control: private, must-revalidate'); // 支持页面回跳
header('P3P: CP=CAO PSA OUR'); // 解决IE中iframe跨域访问cookie/session的问题
@ini_set("session.cookie_httponly", 1); //防止cookie被js获取

spl_autoload_register(function ($className) {
    $className = ltrim($className, '\\');
    $fileName = '';
    if ($lastNsPos = strripos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }

    $fileName = ROOT_DIR . $fileName . $className . '.class.php';
    if (file_exists($fileName)) {
        require $fileName;
        return true;
    }
    return false;
});

require_once '../../vendor/autoload.php';


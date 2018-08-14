<?php
/**
 * 系统常量
 */
// 根路径
define('ROOT_DIR', dirname(dirname(__FILE__))."/"); 

// app路径
define("GLOBAL_DIR", ROOT_DIR.'app/');

// web路径
define("WEB_DIR", ROOT_DIR.'web/');

// crontab
define('CRONTAB_DIR', ROOT_DIR."crontab/"); 

// var路径
define("VAR_DIR", ROOT_DIR.'var/');

// 底层库目录
define('LIB_DIR', GLOBAL_DIR.'lib/');

// 数据访问层目录
define('DAL_DIR', GLOBAL_DIR.'dal/');

// API目录
define('API_DIR', WEB_DIR.'api/');

// logs路径
define("LOG_DIR", VAR_DIR.'logs/');

//缓存目录
define('CACHE_DIR', VAR_DIR.'cache/');

//配置目录
define('CONFIG_DIR', GLOBAL_DIR.'config/');

// 文本目录
define("TEXT_DIR", ROOT_DIR.'text/');

// admin目录
define('ADMIN_DIR', WEB_DIR.'admin/');

// app目录
define('APP_DIR', ADMIN_DIR.'app/');

// 语言目录
define('LANG_DIR', APP_DIR.'lang/');

//上传文件目录
define('ADMIN_UF_DIR', ADMIN_DIR.'uploadfile/');

// APP的权限标识常量定义
define('ACT_NEED_AUTH', 0);     //需要登录并验证
define('ACT_NEED_LOGIN', 1);    //需要登录
define('ACT_OPEN', 2);          //完全开放

// 定义错误码
define('SUCCESS', 0); // 正常返回
define('FAIL', -1); // 返回错误

$env = getenv('APP_ENV') ?? 'dev';
define('APP_ENV', $env);

if(APP_ENV == 'dev'){
	define('DEBUG', true);
    error_reporting(E_ALL);
}else{
	define('DEBUG', true);
    error_reporting(0);
}


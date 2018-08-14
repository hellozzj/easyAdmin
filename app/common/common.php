<?php
require_once('define.php');

require_once(APP_DIR.'common/functions.php');
require_once(LIB_DIR.'mysql/mysqlfunctions.php');
require_once(LIB_DIR.'mysql/mysqlinstance.php');

//数据库
$g_global['db'] = new MysqlInstance();

//语言包
$g_global['lang'] = (!empty($_GET['lang']) && array_key_exists($_GET['lang'], $g_c['lang'])) ? $_GET['lang'] : $g_c['lang_default'];
require_once(ROOT_DIR.'language/'.$g_global['lang']."/lang_common.php");
?>
<?php

return array(
    //用户账号支付广告库
    "user" => array(
        "driver" => 'mysql',
        'master'=> array('host'=>'CNF_W_PLAT_MYSQL_MASTER_IP', 'port'=> CNF_W_PLAT_MYSQL_PORT),
        'slave'=> array(
            array('host'=>'CNF_W_PLAT_MYSQL_SLAVE_IP', 'port'=> CNF_W_PLAT_MYSQL_PORT),
            array('host'=>'CNF_W_PLAT_MYSQL_SLAVE_IP', 'port'=> CNF_W_PLAT_MYSQL_PORT),
        ),
        "user"=>"CNF_W_PLAT_MYSQL_USER",
        "pwd"=>"CNF_W_PLAT_MYSQL_PW",
        'dbname' => 'CNF_W_PLAT_MYSQL_NAME',
        'charset' => 'utf8',
    ),
    //后台数据库
    "main" => array(
        "driver" => "mysql",
        'master'=> array('host'=>'CNF_W_MANAGER_MYSQL_MASTER_IP', 'port'=> CNF_W_MANAGER_MYSQL_PORT),
        'slave'=> array(
            array('host'=>'CNF_W_MANAGER_MYSQL_SLAVE_IP', 'port'=> CNF_W_MANAGER_MYSQL_PORT),
            array('host'=>'CNF_W_MANAGER_MYSQL_SLAVE_IP', 'port'=> CNF_W_MANAGER_MYSQL_PORT),
        ),
        "user"=>"CNF_W_MANAGER_MYSQL_USER",
        "pwd"=>"CNF_W_MANAGER_MYSQL_PW",
        "dbname"=>"CNF_W_MANAGER_MYSQL_NAME",
        "charset"=>"utf8",
    ),
    //日志库
    "log" => array(
        "driver" => "mysql",
        'master'=> array('host'=>'CNF_W_GAME_MYSQL_MASTER_IP', 'port'=> CNF_W_GAME_MYSQL_PORT),
        'slave'=> array(
            array('host'=>'CNF_W_GAME_MYSQL_SLAVE_IP', 'port'=> CNF_W_GAME_MYSQL_PORT),
            array('host'=>'CNF_W_GAME_MYSQL_SLAVE_IP', 'port'=> CNF_W_GAME_MYSQL_PORT),
        ),
        "user"=>"CNF_W_GAME_MYSQL_USER",
        "pwd"=>"CNF_W_GAME_MYSQL_PW",
        "dbname"=>"CNF_W_GAME_MYSQL_NAME",
        "charset"=>"utf8",
    ),
    //sdk库
    "sdk" => array(
        "driver" => "mysql",
        'master'=> array('host'=>'CNF_W_SDK_MYSQL_MASTER_IP', 'port'=> CNF_W_SDK_MYSQL_PORT),
        'slave'=> array(
            array('host'=>'CNF_W_SDK_MYSQL_SLAVE_IP', 'port'=> CNF_W_SDK_MYSQL_PORT),
            array('host'=>'CNF_W_SDK_MYSQL_SLAVE_IP', 'port'=> CNF_W_SDK_MYSQL_PORT),
        ),
        "user"=>"CNF_W_SDK_MYSQL_USER",
        "pwd"=>"CNF_W_SDK_MYSQL_PW",
        "dbname"=>"CNF_W_SDK_MYSQL_NAME",
        "charset"=>"utf8",
    ),
);

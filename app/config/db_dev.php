<?php

return array(
    //后台数据库
    "main" => array(
        "driver" => "mysql",
        'master'=> array('host'=>'prd-mysql', 'port'=> 3306),
        'slave'=> array(
            array('host'=>'prd-mysql', 'port'=> 3306),
            array('host'=>'prd-mysql', 'port'=> 3306),
        ),
        "user"=>"root",
        "pwd"=>"123123",
        "dbname"=>"db_backend",
        "charset"=>"utf8",
        "alias" => "CConstant::DB_MAIN"
    ),
);

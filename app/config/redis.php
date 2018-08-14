<?php

return array(
    // 用户缓存
    "user" => array(
        'master'=> array('host'=>'prd-redis', 'port'=> 6379, 'pwd'=> ''),
        'slave'=> array(
            array('host'=>'', 'port'=> 6379, 'pwd'=> ''),
            array('host'=>'prd-redis', 'port'=> 6379, 'pwd'=> ''),
        )
    ),
); 

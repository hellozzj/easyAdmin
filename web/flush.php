<?php
include('../global/header.php');
$redis = MyRedis::getMasterInstance(CConstant::REDIS_LOG);
$redis -> flush_all();
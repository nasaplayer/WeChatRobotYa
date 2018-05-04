<?php
error_reporting(E_ALL^E_NOTICE);
date_default_timezone_set('Asia/Shanghai');

include 'WeChatRobotYa.class.php';
include 'myDB.class.php';

$ya=new WeChatRobotYa();
$ya->main();





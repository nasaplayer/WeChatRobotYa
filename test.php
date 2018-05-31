<?php
date_default_timezone_set('Asia/Shanghai');
include 'WeChatRobotYa.class.php';
include 'TestYa.class.php';


$type = $_GET['t']??'text';
$Content = $_GET['c']??'图文';

//$type = 'subscribe';//测试 关注 事件

$TestYa=new TestYa($type,$Content);

$TestYa->listen();






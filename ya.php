<?php
date_default_timezone_set('Asia/Shanghai');

include 'WeChatRobotYa.class.php';
include 'myDB.class.php';


$Token = 'codenight';//令牌(Token),必填与微信公众号配置一致
$logLv = 3;//0- 不开启  1-记录到XML文件 2-记录到数据库 3-同时记录到XML文件和数据库
$ya=new WeChatRobotYa($Token,$logLv);
$ya->listen();





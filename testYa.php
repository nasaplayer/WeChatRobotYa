<?php
date_default_timezone_set('Asia/Shanghai');
include 'WeChatRobotYa.class.php';


$xml=<<<XML
<xml>
	<ToUserName><![CDATA[gh_747e2105165a]]></ToUserName>
	<FromUserName><![CDATA[op181vw09SsmHbIFe99T0YZxGMxE]]></FromUserName>
	<CreateTime>1525233066</CreateTime>
	<MsgType><![CDATA[event]]></MsgType>
	<Event><![CDATA[subscribe]]></Event>
	<EventKey><![CDATA[]]></EventKey>
</xml>
XML;

$xml_text=<<<XML
<xml>
	<ToUserName><![CDATA[gh_747e2105165a]]></ToUserName>
	<FromUserName><![CDATA[op181vw09SsmHbIFe99T0YZxGMxE]]></FromUserName>
	<CreateTime>1525233066</CreateTime>
	<MsgType><![CDATA[text]]></MsgType>
	<Content><![CDATA[图文]]></Content>
</xml>
XML;

$ya=new WeChatRobotYa();
$ya->main($xml_text);


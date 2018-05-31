<?php


class TestYa{
	
	private $Token = 'codenight';
	private $logLv = 1;
	private $model = '测试';
	
	public $type =  '';
	public $Content = '';
	
	
	public function __construct($type='text',$Content='图文'){
		$this->type = $type;
		$this->Content = $Content;
	}
	
	public function listen(){
		
		switch($this->type){
			case 'text':
				$this->text($this->Content);
				break;
			case 'subscribe':
				$this->subscribe();
				break;
			default:
				echo '无效的type';
				break;
		}
		
		
	}
	
	public function text($Content){
		$param = [
			'Content'=>$Content,
		];
		$this->sendXMLStr('text',$param);
	}
	
	public function subscribe(){
		$param = [];
		$this->sendXMLStr('event-subscribe',$param);
	}
	
	public function sendXMLStr($type,$param){
		
		$xmlTemp = $this->getUserXML($type);
		
		$defaultParam = [
			'CreateTime'=>time(),
		];
		
		$param = array_merge($defaultParam,$param);
		
		$xmlStr = $this->setXMLStr($xmlTemp, $param);
		
		$ya=new WeChatRobotYa($this->Token,$this->logLv,$this->model);
		$ya->test($xmlStr);
		
		$this->showXML($xmlStr);
	}
	
	public function showXML($xmlStr){
		echo '<pre>'.htmlspecialchars($xmlStr).'</pre>';
	}
	
	public function setXMLStr($xmlTemp, $param){
		$param = array_values($param);
		$xmlStr = sprintf($xmlTemp, ...$param);
		return $xmlStr;
	}
	
	
public function getUserXML($type){
	$xmlTemp = '';
	switch($type){
		case 'text':
$xmlTemp=<<<XML
<xml>
	<ToUserName><![CDATA[gh_747e2105165a]]></ToUserName>
	<FromUserName><![CDATA[op181vw09SsmHbIcodenightFe99]]></FromUserName>
	<CreateTime>%d</CreateTime>
	<MsgType><![CDATA[text]]></MsgType>
	<Content><![CDATA[%s]]></Content>
</xml>
XML;
			break;
		case 'event-subscribe':
$xmlTemp=<<<XML
<xml>
	<ToUserName><![CDATA[gh_747e2105165a]]></ToUserName>
	<FromUserName><![CDATA[op181vw09SsmHbIcodenightFe99]]></FromUserName>
	<CreateTime>%d</CreateTime>
	<MsgType><![CDATA[event]]></MsgType>
	<Event><![CDATA[subscribe]]></Event>
	<EventKey><![CDATA[]]></EventKey>
</xml>
XML;
			break;
		
	}
	
	return $xmlTemp;
}//getUserXML

}//class TestYa
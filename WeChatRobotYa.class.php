<?php



class WeChatRobotYa{
	
	public $MsgType ='';
	public $ToUserName ='';			//gh_747e2105165a
	public $FromUserName ='';		//op181vw09SsmHbIFe99T0YZxGMxE
    public $xmlObj =null;
    
    private $Token = 'codenight';	//令牌(Token),必填与微信公众号配置一致
    private $logState =  1;  //0- 不开启 1-记录到xml文件 2-记录到数据库 3-同时记录到文件和数据库
    
    public function main(){
		if (!isset($_GET['echostr'])) {
		    $this->reply();
		}else{
		    $this->valid();
		}
    }
    
    public function valid(){
       
        $signature = $_GET["signature"];
		
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
		$echostr = $_GET["echostr"];
		
		$token = $this->Token;
		 
        $tmpArr = [$token, $timestamp, $nonce];
		
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if($tmpStr == $signature){
            echo $echostr;
            die;
        }
    }//valid
    

public function reply(){
	$postStr = file_get_contents("php://input");

	if (!empty($postStr)){
		$this->log('收到',$postStr);
		$this->init($postStr);
		
		switch($this->MsgType){
			case 'text':
				$this->solveText();
				break;
			case 'event':
				$this->solveEvent();
				break;
		}//switch
		
	}else{
		echo 'success';
	}
	
}//replyCenter

public function init($postStr){
	$xmlObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
	
	$this->MsgType = $xmlObj->MsgType;
	$this->ToUserName = $xmlObj->ToUserName;
	$this->FromUserName = $xmlObj->FromUserName;
	$this->xmlObj = $xmlObj;
}

public function solveText(){
	$Content = $this->xmlObj->Content;
	
	preg_match("/\d+\.?\d*/i", $Content, $match);
	
	//自动回答MySQL错误
	if(count($match)>0){
		$num = $match[0];
		$this->mysqlErrorMsg($num);
	}

	if(strstr($Content, "图文")){
		$this->replyArticleList();
	}else{
    	$Content = date("Y-m-d H:i:s",time())."\n主人不在我是机器人[小雅],目前IQ为-1还不能理解你说的内容\n发送【图文】两字 获取文章列表";
       
	}
	
	$this->replyText($Content);
}//solveText


public function solveEvent(){
	$Event = $this->xmlObj->Event;
	switch($Event){
		case 'subscribe'://关注
			$this->subscribe();
			break;
		case 'unsubscribe':
			break;
	}//switch
	
}//solveEvent

public function subscribe(){
	$Content=<<<EOD
在这里等你好久了、今日相识于此,往后行走江湖便多一个朋友	
EOD;
	$this->replyText($Content);
}//subscribe


public function replyArticleList(){
	$arr = [];
	$Articles = '';
	$arr = [
		[
  			"Title"=>"php特性与mysqli融合铸造数据库插入之剑", 
            "Description"=>"", 
            "PicUrl"=>"http://mmbiz.qpic.cn/mmbiz_jpg/icuwTZfrQnGMTnr93wxJJiaJPSLyaAa3HXg6yS2X0Gv0ib6vN8cQ7y3DAiacL1CkCAxZOKzpGKm8XWV546oicEGFv7g/0?wx_fmt=jpeg", 
            "Url" =>"https://mp.weixin.qq.com/s?__biz=MzIwNzk0NjE1MQ==&mid=2247484116&idx=2&sn=247efc5f4f5d65f03ec3036c7e6b0005&chksm=970bea1ca07c630af50d0ce6d715436b1e39b362a0d9aafe91a45d791f9adbb375e834bf6867#rd",
		
		],
		[
            "Title"=>"编程话江湖，原力铸神兵", 
            "Description"=>"111", 
            "PicUrl"=>"http://mmbiz.qpic.cn/mmbiz_jpg/icuwTZfrQnGMOKbJbo7Vv6Crk3icOOVX4j7HbbAT4uphYS11rib8SPOfjSXby4bwYK7K5afNWp2WwLPPFAN7zFvBw/0?wx_fmt=jpeg", 
            "Url" =>"https://mp.weixin.qq.com/s?__biz=MzIwNzk0NjE1MQ==&mid=2247484116&idx=1&sn=b3444ca18f25343bac3939d31602bea5&chksm=970bea1ca07c630ac39b83882b4cd30356e1dad270272f87de860b92a2c4f9f022969059b81f#rd",
		],
	];
	
	$ArticleCount  = count($arr);
	
	$xmlTemp = $this->getXML('one_new');	
	for($i=0;$i<$ArticleCount;$i++){
		$param = $arr[$i];
		$Articles.= $this->setXMLStr($xmlTemp, $param);
	}
	
	$param = [
		'ArticleCount'=>$ArticleCount,
		'Articles'=>$Articles,
	];
	
	$this->echoXMLStr('news',$param);
}

public function replyText($Content){
	$param = [
		'Content'=>$Content,
	];
	
	$this->echoXMLStr('text',$param);
}

public function replyImage($MediaId){

	$param = [
		'MediaId'=>$MediaId,
	];
	
	$this->echoXMLStr('image',$param);
}


public function echoXMLStr($type,$param){
	
	$xmlTemp = $this->getXML($type);
	
	$defaultParam = [
		'ToUserName'=>$this->FromUserName,
		'FromUserName'=>$this->ToUserName,
		'CreateTime'=>time(),
	];
	
	$param = array_merge($defaultParam,$param);
	
	$xmlStr = $this->setXMLStr($xmlTemp, $param);
	
	$this->log('回复',$xmlStr);
	
	echo $xmlStr;
	die;
}


public function setXMLStr($xmlTemp, $param){
	$param = array_values($param);
	$xmlStr = sprintf($xmlTemp, ...$param);
	return $xmlStr;
}

public function getXML($type){
	$xmlTemp = '';
	
switch($type){
	case 'text'://文本
    	$xmlTemp =<<<EOD
<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%d</CreateTime>
    <MsgType><![CDATA[text]]></MsgType>
    <Content><![CDATA[%s]]></Content>
</xml>
EOD;
	break;
	
	case 'news'://文章列表
    	$xmlTemp =<<<EOD
<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%d</CreateTime>
    <MsgType><![CDATA[news]]></MsgType>
    <ArticleCount>%d</ArticleCount>
    <Articles>%s</Articles>
</xml>
EOD;
		break;
	case 'one_new'://单个文章子节点
    	$xmlTemp =<<<EOD
<item>
	<Title><![CDATA[%s]]></Title>
	<Description><![CDATA[%s]]></Description>
	<PicUrl><![CDATA[%s]]></PicUrl>
	<Url><![CDATA[%s]]></Url>
</item>
EOD;
		break;
	
	case 'image':
    	$xmlTemp =<<<EOD
<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%d</CreateTime>
    <MsgType><![CDATA[image]]></MsgType>
    <Image>
    	<MediaId><![CDATA[%s]]></MediaId>
    </Image>
</xml>
EOD;
		break;
	
}//switch
	return $xmlTemp;
}//getXML

public function mysqlErrorMsg(int $code){

	if($code>=1000){
		
		switch($code){
			case 1050:
				$Content = '创建表或视图，已存在同名视图或表';
				break;
			case 1064:
				$Content = '你的SQL语句中存在一个错误';
				break;
			case 1111:
				$MediaId= '5wktHzKpL3dazv3BXzPDs8QJPB3CwjmBSiAku8IFbuoWhwLBD8Ooiprx4PNVntJ9';
				$this->replyImage($MediaId);
				break;
			default:
				$Content ='无法判断的错误类型，已记录';
				break;
		}//switch
		
	}//if
	
	$Content ="错误码:{$code}\n".$Content;
	
	$this->replyText($Content);

//https://dev.mysql.com/doc/refman/8.0/en/error-messages-server.html
}//mysqlErrorMsg


    
    public function test($postStr){
		$this->log('收到',$postStr);
		$this->init($postStr);
		
		switch($this->MsgType){
			case 'text':
				$this->solveText();
				break;
			case 'event':
				$this->solveEvent();
				break;
		}//switch
    }//test
    

public function log($type,$content){
	
	switch($this->logState){
		case 3:
			$this->dbLog($type,$content);
			$this->fileLog($type,$content);
			break;
		case 2:
			$this->dbLog($type,$content);
			break;
		case 1:
			$this->fileLog($type,$content);
			break;
		default:
			
			break;
		
	}
	

	
}//dbLog

public function dbLog($type,$content){
	$msg = new myDB('msg');
	
	$add_time = date('Y-m-d H:i:s',time());
	
	$arr = [
		'type'=>$type,
		'content'=>$content,
		'add_time'=>$add_time,
	];
	$msg->add($arr);
}

public function fileLog($type,$content){
	$max_size = 1024000;//斜杠的方向
    $fileName = date('Y-m-d').'_log.xml';
    $dir = dirname(__FILE__).'/log/';//
    if(!is_dir($dir)){
    	mkdir($dir);
    }
    echo dirname(__FILE__);
    if(file_exists($fileName) && (abs(filesize($fileName)) > $max_size)){
    	unlink($fileName);
    }
	//$dir.'/'.
	$head = '['.$type.']'.date('Y-m-d_H.i.s').PHP_EOL;
    $data = $head.$content.PHP_EOL.PHP_EOL.PHP_EOL;
    file_put_contents($dir.$fileName, $data, FILE_APPEND);
}

}//WeChatRobotYa
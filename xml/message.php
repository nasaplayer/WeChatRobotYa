
1、xml字段排列顺序有无影响
2、


<ToUserName><![CDATA[gh_747e2105165a]]></ToUserName> 开发者微信号
<FromUserName><![CDATA[op181vw09SsmHbIFe99T0YZxGMxE]]></FromUserName> 一个OpenID
<CreateTime>1525233066</CreateTime>


//取消关注
<xml>
	<MsgType><![CDATA[event]]></MsgType>
	<Event><![CDATA[unsubscribe]]></Event>
	<EventKey><![CDATA[]]></EventKey>
</xml>

//关注
<xml>
	<MsgType><![CDATA[event]]></MsgType>
	<Event><![CDATA[subscribe]]></Event>
	<EventKey><![CDATA[]]></EventKey>
</xml>

//接收 文本消息
<xml>
	<MsgType><![CDATA[text]]></MsgType>
	<Content><![CDATA[你好]]></Content>
	<MsgId>6550828220784221208</MsgId>
</xml>

//回复 文本消息
<xml>
	<MsgType>< ![CDATA[text]]></MsgType>
	<Content>< ![CDATA[你好]]></Content>
</xml>


<xml>
<ToUserName><![CDATA[gh_747e2105165a]]></ToUserName>
<FromUserName><![CDATA[op181vw09SsmHbIFe99T0YZxGMxE]]></FromUserName>
<CreateTime>1525261228</CreateTime>
<MsgType><![CDATA[image]]></MsgType>
<PicUrl><![CDATA[http://mmbiz.qpic.cn/mmbiz_jpg/XZCxShtM29BbW1CrGdMW4PHGxicuyLiah77tQMTabEPNNVHZOEh6ichTopUb17mvbTQh7yrGWwvDyJ3yAJh0ibEaEQ/0]]></PicUrl>
<MsgId>6550947092594082205</MsgId>
<MediaId><![CDATA[5wktHzKpL3dazv3BXzPDs8QJPB3CwjmBSiAku8IFbuoWhwLBD8Ooiprx4PNVntJ9]]></MediaId>
</xml>

<xml>
	<ToUserName>
		< ![CDATA[toUser] ]>
	</ToUserName>
	<FromUserName>
		< ![CDATA[fromUser] ]>
	</FromUserName>
	<CreateTime>12345678</CreateTime>
	<MsgType>
		< ![CDATA[image] ]>
	</MsgType>
	<Image>
		<MediaId><![CDATA[media_id]]></MediaId>
	</Image>
</xml>
<xml>
	<ToUserName>
		< ![CDATA[toUser] ]>
	</ToUserName>
	<FromUserName>
		< ![CDATA[fromUser] ]>
	</FromUserName>
	<CreateTime>12345678</CreateTime>
	<MsgType>
		< ![CDATA[news] ]>
	</MsgType>
	<ArticleCount>2</ArticleCount>
	<Articles>
<item>
	<Title><![CDATA[title1]]></Title>
	<Description><![CDATA[description]]></Description>
	<PicUrl><![CDATA[picurl]]></PicUrl>
	<Url><![CDATA[url]]></Url>
</item>
		<item>
			<Title>
				< ![CDATA[title] ]>
			</Title>
			<Description>
				< ![CDATA[description] ]>
			</Description>
			<PicUrl>
				< ![CDATA[picurl] ]>
			</PicUrl>
			<Url>
				< ![CDATA[url] ]>
			</Url>
		</item>
	</Articles>
</xml>


//统计群发

<xml>
	<ToUserName><![CDATA[gh_747e2105165a]]></ToUserName>
	<FromUserName><![CDATA[op181vwDKgDGw35cpvwKKgC1xbGo]]></FromUserName>
	<CreateTime>1525140182</CreateTime>
	<MsgType><![CDATA[event]]></MsgType>
	<Event><![CDATA[MASSSENDJOBFINISH]]></Event>
	<MsgID>1000000047</MsgID>
	<Status><![CDATA[send success]]></Status>
	<TotalCount>278</TotalCount>
	<FilterCount>278</FilterCount>
	<SentCount>278</SentCount>
	<ErrorCount>0</ErrorCount>
	<CopyrightCheckResult><Count>0</Count>
	<ResultList></ResultList>
	<CheckState>0</CheckState>
	</CopyrightCheckResult>
</xml>
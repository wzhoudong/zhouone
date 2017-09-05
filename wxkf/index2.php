<?php
	$postStr = " <xml>
			 <ToUserName><![CDATA[zhoudong]]></ToUserName>
			 <FromUserName><![CDATA[zhangjiao]]></FromUserName> 
			 <CreateTime>1348831860</CreateTime>
			 <MsgType><![CDATA[text]]></MsgType>
			 <Content><![CDATA[this is a test]]></Content>
			 <MsgId>1234567890123456</MsgId>
			 </xml>";
    	$postObj = simplexml_load_string($postStr,'SimpleXMLElement', LIBXML_NOCDATA )	;
    	var_dump($postObj);

    	echo "<hr>";
    	$post = "<xml>
			<ToUserName><![CDATA[toUser]]></ToUserName>
			<FromUserName><![CDATA[fromUser]]></FromUserName>
			<CreateTime>12345678</CreateTime>
			<MsgType><![CDATA[image]]></MsgType>
			<Image>
			<MediaId><![CDATA[media_id]]></MediaId>
			</Image>
			</xml>";
	$postOb = simplexml_load_string($post,'SimpleXMLElement', LIBXML_NOCDATA )	;
	var_dump($postOb);

	echo "<hr>";
	$xml = '<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[fromUser]]></FromUserName>
<CreateTime>12345678</CreateTime>
<MsgType><![CDATA[video]]></MsgType>
<Video>
<MediaId><![CDATA[media_id]]></MediaId>
<Title><![CDATA[title]]></Title>
<Description><![CDATA[description]]></Description>
</Video> 
</xml>';
	$zeng = simplexml_load_string($post,'SimpleXMLElement', LIBXML_NOCDATA )	;
	var_dump($zeng);

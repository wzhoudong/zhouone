<?php 
	/*
	 * 	接收GET传过来的参数
	 *	判断信息的真实性
	*/
	//GET接收微信加密签名
	$signature = $_GET['signature'];

	//GET接收时间戳
	$timestamp = $_GET['timestamp'];

	//GET接收随机数
	$nonce = $_GET['nonce'];

	define("TOKEN", "zhoudong");
	//GET接收随机字符串
	$echostr = $_GET['echostr'];

	$tmpArr = array(TOKEN, $timestamp, $nonce);
  	sort($tmpArr, SORT_STRING);
  	$tmpStr = implode( $tmpArr );
  	$tmpStr = sha1( $tmpStr );
  	if($tmpStr == $signature){
  		echo $echostr;
  	}else{
  		echo "error";
  		exit;
  	}
  	/*
	 *	通过POST接收xml数据；
	 *	接收信息功能
	 *	$obj = simplexml_load_string($xml,'SimpleXMLElment',LIBXML_NOCDATA)	将xml转化成对象	取的话$obj -> Content;
  	*/
  	$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
  	if(!$postStr){
  		echo "post data error";
  		exit;
  	}
  	/*
	 * 	将xml数据转化为对象
	 *	自动回复功能
  	 *	从postObj对象中取元素
  	*/
  	
  	$postObj = simplexml_load_string($postStr,'SimpleXMLElement',LIBXML_NOCDATA);
  	$MsgType = $postObj ->MsgType;
  	switch ($MsgType) {
  		case 'text':
  			$content = $postObj ->Content;
  			switch ($content) {
  					case 'zhangjiao':
						$xml = '<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%d</CreateTime>
							<MsgType><![CDATA[text]]></MsgType>
							<Content><![CDATA[%s]]></Content>
						</xml>';
						echo sprintf($xml,$postObj->FromUserName,$postObj->ToUserName,time(),'I love you');
  					break;
  				default:
						$xml = '<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%d</CreateTime>
							<MsgType><![CDATA[text]]></MsgType>
							<Content><![CDATA[%s]]></Content>
						</xml>';
						echo sprintf($xml,$postObj->FromUserName,$postObj->ToUserName,time(),$postObj ->Content);
  					break;
  			}
  			break;
  		case 'image':
					$xml = '<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%d</CreateTime>
							<MsgType><![CDATA[image]]></MsgType>
							<Image>
							<MediaId><![CDATA[%s]]></MediaId>
							</Image>
						</xml>';
						echo sprintf($xml,$postObj->FromUserName,$postObj->ToUserName,time(),$postObj->MediaId);
				break;
  		default:
  			break;
  	}








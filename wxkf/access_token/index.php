<?php 
	$appid = 'wx587e0f9288074306';
	$appsecret = '41ae7ff161874c170516dbae4b2fdc49';
	$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";

	$ch = curl_init();

	//设置传输选项
	//设置传输地址
	curl_setopt($ch,CURLOPT_URL,$url);
	//以文件流的形式返回
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	//发送curl
	$arr = curl_exec($ch);
	$zd = json_decode($arr,TRUE);
	echo '<pre>';
	print_r($zd);
	echo '</pre>';
	//关闭资源
	curl_close($ch);
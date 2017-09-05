<?php 
	header("Content-type:text/html;charset=utf-8");
	$appid = 'wx587e0f9288074306';
	$appsecret = '41ae7ff161874c170516dbae4b2fdc49';
	$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
	//开启curl
	$ch = curl_init();

	//设置传输选项
	//设置传输地址
	curl_setopt($ch,CURLOPT_URL,$url);
	//以文件流的形式返回
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	//发送curl
	$arr = curl_exec($ch);
	$zd = json_decode($arr,TRUE);
	$access_tokens = $zd['access_token'];
	//关闭资源
	curl_close($ch);

	//发送GET请求接口
	$url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token={$access_tokens}";
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	$str = curl_exec($ch);
	$zhoudong = json_decode($str,TRUE);
	echo '<pre>';
	print_r($zhoudong);
	echo '</pre>';
	curl_close($ch);








	


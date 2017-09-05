<?php 
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
	$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$access_tokens}";

	//创建菜单
	$data = '{
     "button":[
     {	
          "type":"click",
          "name":"喜悦天堂",
          "key":"V1001_TODAY_MUSIC"
      },
      {
           "name":"周冬领域",
           "sub_button":[
           {	
               "type":"view",
               "name":"搜索",
               "url":"http://www.runoob.com/"
            },
            {
               "type":"view",
               "name":"视频",
               "url":"http://v.runoob.com/"
            },
            {
               "type":"click",
               "name":"赞一下我们",
               "key":"V1001_GOOD"
            }]
       }]
 }';
	//开启curl
	$ch = curl_init();

	//设置传输选项
	//设置传输地址
	curl_setopt($ch,CURLOPT_URL,$url);
	//以文件流的形式返回
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	//以POST方式
	curl_setopt($ch,CURLOPT_POST,1);
	//
	curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
	//发送curl
	$arr1 = curl_exec($ch);
	$zd1 = json_decode($arr1,TRUE);
	echo '<pre>';
	print_r($zd1);
	echo '</pre>';
	exit;
	//$access_tokens = $zd['access_token'];
	//关闭资源
	curl_close($ch);

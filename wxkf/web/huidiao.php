<?php 
      include './config.php';

      $config = new Config();

	session_start();

      //模拟GET，POST请求
  	function https_request($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);
		return json_decode($output, true);
    	}

      //获取第一步返回的code码
      $code = $_GET["code"];

      /*
      *    第二步：通过code换取网页授权access_token
      *    code 第一步获取的code参数
      *    grant_type 填写为authorization_code 
      *    返回的参数:
      *    access_token 网页授权接口调用凭证,注意：此access_token与基础支持的access_token不同
      *    openid 用户唯一标识，请注意，在未关注公众号时，用户访问公众号的网页，也会产生一个用户和公众号唯一的OpenID
      */
      $getAccessToken = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$config->appid}&secret={$config->appsecret}&code={$code}&grant_type=authorization_code";

      $getAccessTokenArr = https_request($getAccessToken);

      $access_token = $getAccessTokenArr["access_token"];

      $openid = $getAccessTokenArr['openid'];

      /*
      *    第三步：拉取用户信息(需scope为 snsapi_userinfo)
      *    openid   用户的唯一标识
      *    access_token   网页授权接口调用凭证,注意：此access_token与基础支持的access_token不同
      *    lang   zh_CN 简体，zh_TW 繁体，en 英语
      */
      $getUserInfo = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";

      $userinfo = https_request($getUserInfo);

    	if(!isset($userinfo['errmsg'])){
    		$_SESSION['userinfo'] = $userinfo;

    		header("Location:wushen.php");
    	}
      //打印错误码
    	print_r($userinfo);
    



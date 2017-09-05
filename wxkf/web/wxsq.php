<?php 
	include './config.php';

	$config = new Config();

	/*
	 * 	第一步：用户同意授权，获取code
	 *	scope为snsapi_userinfo （弹出授权页面，可通过openid拿到昵称、性别、所在地。并且，即使在未关注的情	况下，只要用户授权，也能获取其信息）
	 *	scope为snsapi_base （不弹出授权页面，直接跳转，只能获取用户openid）
	 *	response_type 返回类型，请填写code
	 *	#wechat_redirect 无论直接打开还是做页面302重定向时候，必须带此参数
	*/
	$url ="https://open.weixin.qq.com/connect/oauth2/authorize?appid={$config->appid}&redirect_uri={$config->redirectUri()}&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";

	if(!$_GET){
  		header("Location:".$url);
		exit();
	}

	//第一步:取得openid
	return $code = $_GET["code"];



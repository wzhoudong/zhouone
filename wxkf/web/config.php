<?php 
	class Config
	{
		//公众号的唯一标识
		public $appid='wx587e0f9288074306';

		//公众号公钥
		public $appsecret = "41ae7ff161874c170516dbae4b2fdc49";

		//回调链接
		public function redirectUri(){
			return  urlencode("http://www.afefgrw.top/wxkf/web/huidiao.php");
		}
	}
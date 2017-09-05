<?php
include "../weichat.class.php";
$appid="wx587e0f9288074306";
$timestamp=time();
$nonceStr='1212121212';
define("TOKEN", "zhoudongs");
$weChat=new weiChat('wx587e0f9288074306','41ae7ff161874c170516dbae4b2fdc49');

// 获取ticket
$url="https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$weChat->get_access_token()}&type=jsapi";


$ticketArr=$weChat->https_request($url);

$ticket=$ticketArr['ticket'];

// 拼接字符串

$str="jsapi_ticket={$ticket}&noncestr={$nonceStr}&timestamp={$timestamp}&url=http://www.afefgrw.top/jssdk/jssdk.php";
// echo "$str";
$signature=sha1($str);
echo "<br>";
echo "$signature";
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
</head>
<body>
	<button onclick="a()">选择图片</button>
	<div id="main"></div>
	<button onclick="b()">扫一扫</button>
	<button onclick="c()">预览</button>

</body>
<script>
	
	wx.config({
	    debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
	    appId: '<?php echo $appid?>', // 必填，公众号的唯一标识
	    timestamp: <?php echo $timestamp?>, // 必填，生成签名的时间戳
	    nonceStr: '<?php echo $nonceStr?>', // 必填，生成签名的随机串
	    signature: '<?php echo $signature?>',// 必填，签名，见附录1
	    jsApiList: ['chooseImage','scanQRCode','previewImage'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
	});

	wx.ready(function(){

	});
	var aa=[];
	function a(){
			var main=document.getElementById('main');
			var images = {
			    	localId: [],
			    	serverId: []
		  	};
		  	var str='';
		 	wx.chooseImage({
			      success: function (res) {
			        images.localId = res.localIds;
			        var imgs=images.localId;
			        aa=imgs;
			        for (var i = imgs.length - 1; i >= 0; i--) {
			        	str+='<img src="'+imgs[i]+'"><br/>'
			        };
			        main.innerHTML=str;
			      }
		    	});
	}


	function b(){
		wx.scanQRCode({
	      needResult: 1,
	      desc: 'scanQRCode desc',
	      success: function (res) {
	        alert(JSON.stringify(res));
	      }
	    });
	}

	function c(){
		wx.previewImage({
		      current: aa[0],
		      urls: aa
		    });
	}

</script>
</html>
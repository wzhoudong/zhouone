<?php 
	session_start();
?>
<!DOCTYPE html>
<html>
 <head> 
  <meta charset="utf-8" /> 
  <title>需求2</title> 
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" /> 
  <meta name="author" content="" /> 
 <link rel="stylesheet" type="text/css" href="css/zt_main_web.css">
 
</head>

<body class="wushen_bg">

<div class="wushen">
<div class="wushen_img p_rel">
<img src="images/1.jpg" class="wushen_banner">

 <i class="role_a fl">
<img src="<?php echo $_SESSION['userinfo']['headimgurl']?>" class="wushen_tx">	
</i>

 </div>

<p class="fengx"><img src="images/wushen_l.jpg">长按图片分享给朋友<img src="images/wushen_r.jpg"></p>
<p class="wushen_input clear">游戏大名<input type="text" class="fr" value="<?php echo $_SESSION['userinfo']['nickname']?>"></p>
<div class="wushen_input clear">选择英雄
 
   <select  class="fr"   id="changebg">
<option value="0">请选择英雄</option>
<option value="1">狄仁杰-判案大师</option>
<option value="2">韩信-接头霸王</option>
<option value="3">孙悟空-西部大嫖客</option>


   </select>
 </div>

<p class="text_center"><button type="button" class="wushen_btn">立即生成</button></p></div>
<script src="http://apps.bdimg.com/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="js/weixin.js"></script>
 
</body>

</html>

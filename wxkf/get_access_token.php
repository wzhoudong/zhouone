<?php 
	define("TOKEN", "zhoudongs");
	include "./weichat.class.php";
	$weichat = new weiChat('wx587e0f9288074306','41ae7ff161874c170516dbae4b2fdc49');
	echo $weichat->get_access_token();
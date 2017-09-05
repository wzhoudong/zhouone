<?php 
	header('Content-type:text/html;charset=utf-8');
	define("TOKEN", "zhoudongs");
	include "../weichat.class.php";
	$weichat = new weiChat('wx587e0f9288074306','41ae7ff161874c170516dbae4b2fdc49');
	$arr = $weichat->mune_select();
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
	exit;
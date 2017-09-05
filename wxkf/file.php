<?php 
	header('Content-type:text/html;charset=utf-8');
	//遍历目录下所有文件路径
	$files = scandir('music');
	$i = 1;
	foreach ($files as $key => $v) {
		if($v != '.' && $v != '..'){
			echo $i .' '. $v .'<br>';
			$i++;
		}
	}
	echo "<br>";

<?php
	header("Content-type:text/html; Charset=utf-8");
	if(!empty($_GET['img'])&&!empty($_GET['page']))
	{
		
		$page='page'.$_GET['page'];
		setcookie("icon[$page][back_img]",$_GET['img'], time()+3600*24*90, '/');
	}
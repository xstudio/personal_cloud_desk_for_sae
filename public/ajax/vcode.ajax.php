<?php
	session_start();
	header("Content-type:text/html; Charset=utf-8");
	if(strtolower($_SESSION['vcode'])==strtolower($_GET['vcode']))
		echo "ok";	
<?php
	session_start();
	include '../classes/validatecode.class.php';
	$img=new ValidateCode();
	$img->viewImg();
	$_SESSION['vcode']=$img->getCode();
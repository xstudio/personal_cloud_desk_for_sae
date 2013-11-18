<?php
	header("Content-type:text/html; Charset=utf-8");
	//加载数据库配置文件
	if(!empty($_GET['user_name']))
	{
		$name=trim($_GET['user_name']);
		include '../../config/config.inc.php';
		include '../../classes/database.class.php';
		$db=new DataBase();
		$users=$db	->SELECT(array('user_name'))
					->FROM('user')
					->WHERE("user_name=$name")	
					->SELECT();
		if(empty($users))
			echo 'ok';
	}
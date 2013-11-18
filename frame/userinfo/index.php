<?php
	header("Content-type:text/html; charset=utf-8");
	//加载数据库配置文件
	include '../../config/config.inc.php';
    //加载smarty初始化文件
    include '../../config/init.inc.php';
	//加载公用类库
	include '../../classes/database.class.php';
	$db=new DataBase();
	if(!empty($_POST['action']))
	{
		if(strlen($_POST['user_pwd'])>=6)
		{
			if($_POST['user_pwd']==$_POST['user_pwd_re'])
			{
				$pwd=md5($_POST['user_pwd'].COMSTR);
				$db	->UPDATE('user')
					->SET(array("user_pwd"=>$pwd))
					->WHERE("user_name=$_COOKIE[username]")
					->UPDATE();
				echo '<script type="text/javascript">alert("密码修改成功"); window.top.location.reload();</script>';
			}	
			else
			{
				echo '<script type="text/javascript">alert("两次密码填写不相等"); location.reload();</script>';	
			}
		}
		else
		{
			echo '<script type="text/javascript">alert("密码最少为6个字符");location.reload();</script>';	
		}
	}
	$smarty->display('userinfo.tpl');
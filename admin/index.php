<?php
	session_start();
	header("Content-type:text/html; charset=utf-8");
	
	//session_destroy();
	//加载数据库配置文件
	include '../config/config.inc.php';
    //加载smarty初始化文件
    include '../config/init.inc.php';
	//加载公用类库
	include '../classes/database.class.php';
	include '../classes/syscrypt.class.php';
	include '../classes/validate.class.php';
	$db=new DataBase();
	if(!empty($_POST['name'])&&!empty($_POST['password']))
	{
		$pwd=md5($_POST['password'].COMSTR);
		$count=$db	->SELECT('count(user_name)')
					->FROM('user')
					->WHERE("user_name=$_POST[name]", array(
						'AND'=>"user_pwd=$pwd", 
						'AND'=>"user_admin=1"
					))
					->SELECT();
		if($count!==0)	
		{
			$_COOKIE['username']=$_POST['name'];
			$_SESSION['login']=true;
			$_COOKIE['shell']=$pwd;
			$_COOKIE['sid']=SysCrypt::php_encrypt($pwd, COMSTR);	
		}
		header("Location:./");
	}
    if(!empty($_SESSION['login'])&&$_SESSION['login'])
	{
		//向数据库添加数据
		if(!empty($_POST['action'])&&$_POST['action']=='Add')
		{
			if(Validate::isPost(array('ico_name', 'ico_url', 'ico_type')))
			{
				$db	->INSERT_INTO('icon')	
					->VALUES(array(
						'ico_name'	=>$_POST['ico_name'],
						'ico_url'	=>$_POST['ico_url'],
						'ico_type'	=>$_POST['ico_type']
					))
					->INSERT();
			}else echo '<h1>某字段为空</h1>';
		}
		//退出
		if(!empty($_GET['logout']))
		{
			$_SESSION=array();
			if(isset($_COOKIE[session_name()])){
				setcookie(session_name(),'',time-3600,'/');
			}
			session_destroy();	
			setcookie('shell','',time()-3600,'/');
			setcookie('username','',time()-3600,'/');
			setcookie('sid','',time()-3600,'/');
			header("Location:./");
		}
		//显示所有数据
		include '../config/enum.inc.php';
		$icons=$db	->SELECT(array('ico_id', 'ico_name', 'ico_url', 'ico_type', 'ico_desc'))
					->FROM('icon')
					->SELECT();
		
		$smarty->assign("icons", $icons);
		$smarty->assign("ico_type", $_ICON);
		$smarty->display("admin.tpl");
		
	}
	else $smarty->display("login.tpl");

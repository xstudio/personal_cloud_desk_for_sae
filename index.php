<?php
	session_start();
	header("Content-type:text/html; charset=utf-8");
	//加载数据库配置文件
	include 'config/config.inc.php';
    //加载smarty初始化文件
    include 'config/init.inc.php';
	//加载常用类库
	include 'classes/syscrypt.class.php';
	include 'classes/validate.class.php';
	include 'classes/database.class.php';
	//初始化界面
	function cookieInit($action){
		if($action=='register')
			$time=time()+3600*24;
		else
			$time=time()+3600*24*90;
		setcookie('icon[page1][ico][0][url]','http://weibo.com/',$time,'/');
		setcookie('icon[page1][ico][0][name]','新浪微博',$time,'/');
		setcookie('icon[page1][ico][1][url]','http://www.3366.com/',$time,'/');
		setcookie('icon[page1][ico][1][name]','3366',$time,'/');
		setcookie('icon[page1][ico][2][url]','http://www.manmankan.com/',$time,'/');
		setcookie('icon[page1][ico][2][name]','漫画盒子',$time,'/');
		setcookie('icon[page1][ico][3][url]','http://qzone.qq.com/',$time,'/');
		setcookie('icon[page1][ico][3][name]','QQ空间',$time,'/');
		setcookie('icon[page1][ico][4][url]','http://play.baidu.com/',$time,'/');
		setcookie('icon[page1][ico][4][name]','百度音乐盒',$time,'/');
	}
	if(!empty($_REQUEST['action'])){
		$db=new DataBase();
		//注册
		if($_REQUEST['action']=='register'){
			$name=Validate::userName($_POST['regname']);
			if(!$name){
				return;
			}
			$users=$db	->SELECT(array('user_name'))
						->FROM('user')
						->WHERE("user_name=$name")	
						->SELECT();
			if(!empty($users)){
				return;
			}
			$password=$_POST['regpassword'];
			if(strlen($password)<6){
				return;
			}
			if($_POST['regrepassword']!=$password){
				return;
			}
			if(strtolower($_POST['regvcode'])!=strtolower($_SESSION['vcode'])){
				return;
			}
			$password=md5($_POST['regpassword'].COMSTR);
			$aff_rows=$db	->INSERT_INTO('user')	
							->VALUES(array(
								'user_name'	=>$name,
								'user_pwd'	=>$password
							))
							->INSERT();
			if($aff_rows>0){
				cookieInit('register');
				setcookie('username', $name, time()+3600*24, '/');
				setcookie('shell', $password, time()+3600*24, '/');
				setcookie('sid', SysCrypt::php_encrypt($password, COMSTR),time()+3600*24, '/');
				header("Loaction:./");
			}
			
		}else if($_REQUEST['action']=='login'){	//登录
			if(Validate::isPost('name','password')){
				$name=trim($_POST['name'])	;
				$password=md5($_POST['password'].COMSTR);
				$count=$db	->SELECT('count(user_name)')
							->FROM('user')
							->WHERE("user_name=$name", array('AND'=>"user_pwd=$password"))
							->SELECT();
				if($count!=0){
					cookieInit('');
					if(!empty($_POST['rememberme'])){
						setcookie('username', $name, time()+3600*24*90, '/');
						setcookie('shell', $password, time()+3600*24*90, '/');
						setcookie('sid', SysCrypt::php_encrypt($password, COMSTR),time()+3600*24*90, '/');	
					}else{
						setcookie('username', $name, time()+3600*24, '/');
						setcookie('shell', $password, time()+3600*24, '/');
						setcookie('sid', SysCrypt::php_encrypt($password, COMSTR),time()+3600*24, '/');	
					}
					
				}
			}
		}else if($_REQUEST['action']=='logout'){
			setcookie('username', '', time()-3600*24, '/');
			setcookie('shell', '', time()-3600*24, '/');
			setcookie('sid', '',time()-3600*24, '/');
		}
		header("Location:./");
	}
	$login=true;
	if(empty($_COOKIE['username'])||empty($_COOKIE['shell'])||empty($_COOKIE['sid'])){
		$login=false;
	}else{
		if(SysCrypt::php_decrypt($_COOKIE['sid'], COMSTR)!=$_COOKIE['shell']){
			$login=false;
		}
	}
	$smarty->assign('icon1', $_COOKIE['icon']['page1']);
	$smarty->assign('icon2', $_COOKIE['icon']['page2']);
	$smarty->assign('icon3', $_COOKIE['icon']['page3']);
	$smarty->assign("login", $login);
	$smarty->display("index.tpl");

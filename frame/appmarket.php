<?php
	header("Content-type:text/html; charset=utf-8");
	//加载数据库配置文件
	include '../config/config.inc.php';
    //加载smarty初始化文件
    include '../config/init.inc.php';
	//加载公用类库
	include '../classes/database.class.php';
	include '../config/enum.inc.php';
	include '../classes/page.class.php';
	$db=new DataBase();
	//显示分页数据
	if(!empty($_GET['action'])){
		$total=$db	->SELECT('count(ico_name)')
					->FROM('icon')
					->WHERE("ico_name like $_GET[ico_name]")
					->SELECT();
		$p=new Page(6, $total);
		$icons=$db	->SELECT(array('ico_name', 'ico_url', 'ico_desc'))
					->FROM('icon')
					->WHERE("ico_name like $_GET[ico_name]")
					->LIMIT($p->limitPage())
					->SELECT();
	}else{
		$total=$db	->SELECT('count(ico_name)')
					->FROM('icon')
					->WHERE("ico_type=$_GET[icon]")
					->SELECT();
		$p=new Page(6, $total);
		$icons=$db	->SELECT(array('ico_name', 'ico_url', 'ico_desc'))
					->FROM('icon')
					->WHERE("ico_type=$_GET[icon]")
					->LIMIT($p->limitPage())
					->SELECT();	
	}
	$smarty->assign("total", $total);
	$smarty->assign("icons", $icons);
	$smarty->assign("types", $_ICON);
	$smarty->assign("pageinfo", $p->getPageInfo(array(1,2,3)));
	//注册函数插件
	function cookie_isExist($params, $smarty){
		$result=false;
		foreach($_COOKIE['icon'] as $value){
			foreach($value as $vals){
				foreach($vals as $val){
					if($val['name']==$params['ico_name']){
						$result=true;	
					}
				}
				
			}
		}	
		return $result;
	}
	$smarty->registerPlugin("function","isExist", "cookie_isExist");
	//将一个页面根据请求页面地址缓存成多个文件
    $smarty->display("appmarket.tpl", $_SERVER["REQUEST_URI"]);
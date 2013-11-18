<?php
	header("Content-type:text/html; Charset=utf-8");
	if(!empty($_GET['action']))
	{
		if(!empty($_GET['page'])&&!empty($_GET['ico_name'])&&!empty($_GET['ico_url']))
		{
			
			$page='page'.$_GET['page'];
			$count=empty($_COOKIE['icon'][$page]['ico'])?1:max(array_keys($_COOKIE['icon'][$page]['ico']))+1;
			switch($_GET['action'])		
			{
				case 'add':	
					setcookie("icon[$page][ico][$count][url]",$_GET['ico_url'],time()+3600*24*90,'/');
					setcookie("icon[$page][ico][$count][name]",$_GET['ico_name'],time()+3600*24*90,'/');
					break;
				case 'delete':	
					setcookie("icon[$page]][ico][$count][url]",$_GET['ico_url'],time()-3600*24*90,'/');
					setcookie("icon[$page]][ico][$count][name]",$_GET['ico_name'],time()-3600*24*90,'/');
					break;
				default:
					echo 'error';
			}
		}
	}

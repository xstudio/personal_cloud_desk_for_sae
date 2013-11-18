<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>登录云 - {$smarty.const.SNAME}</title>
<link rel="stylesheet" href="../public/css/login.css" type="text/css" />
<link rel="shortcut icon" href="../public/images/index.ico" type="image/x-icon" />
</head>

<body>
  <div class="container">
		<div class="logo"></div>
        <div class="form">
        	<form action="./" method="post">
                <p>
                    <label>
                        用户名<br/>
                        <input type="text" value="" class="txt" name="name" />
                    </label>
                </p>
                <p>
                    <label>
                    	密码<br/>
                        <input type="password" class="txt" name="password"/>
                    </label>
                </p>
                <p class="bottom">
                	<label class="rem"><input name="rememberme" type="checkbox" value="forever" > 记住我的登录信息</label>
                    <input type="submit" class="sub" value="登录" />
                    <input type="hidden" name="action" value="login" />
                </p>
            </form>
        </div>
        <div class="alink">
        	<p>
        		<a href="../">&larr; 回到 {$smarty.const.SNAME} 首页</a>
        	</p>
        </div>
    </div>	
</body>
</html>
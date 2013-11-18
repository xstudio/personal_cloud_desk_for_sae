<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>修改密码</title>
<style type="text/css">
*{ color:#333; font-size:13px; font-family:微软雅黑;}
body{ padding:0; margin:0;}
table{ border-collapse:collapse;}
td{ line-height:40px; padding-right:10px;}
.txt{ width:200px; border:1px solid #DDD; height:22px; line-height:22px; border-radius:2px; padding:2px;-webkit-border-radius: 2px;}
.sub{ background:#FFF; padding:2px 25px; cursor:pointer; border:1px solid #ccc; -webkit-border-radius: 11px; border-radius:11px;}
.sub:hover{ border-color:#aaa;}
</style>
</head>

<body>
	<form action="./" method="post">
    	<table>
        	<tr>
            	<td>新&nbsp;&nbsp;&nbsp;密&nbsp;&nbsp;&nbsp;码</td>
                <td><input type="text" name="user_pwd" class="txt" /></td>
            </tr>
        	<tr>
            	<td>确认新密码</td>
                <td><input type="text" name="user_pwd_re" class="txt" /></td>
            </tr>
        	<tr>
            	<td></td>
                <td>
                	<input type="hidden" name="action" value="update">
                	<input type="submit" class="sub" />
                </td>
            </tr>
        </table>
    </form>
</body>
</html>

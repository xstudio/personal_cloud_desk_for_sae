<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>管理云 - {$smarty.const.SNAME}</title>
<link rel="stylesheet" href="../public/css/admin.css" type="text/css" />
<link rel="shortcut icon" href="../public/images/index.ico" type="image/x-icon" />
</head>

<body>
	<div class="content">
    	<a href="./?logout=true">退出</a>
    	<table>
        	<caption>应用列表</caption>
        	<tr>
            	<td class="n">应用名</td>
                <td class="u">链接</td>
                <td class="t">类型</td>
                <td class="d">描述</td>
                <td>管理</td>
            </tr>
            {foreach $icons as $icon}
            	<tr>
                	<td>{$icon.ico_name}</td>
                	<td>{$icon.ico_url}</td>
                	<td>{$icon.ico_type}</td>
                	<td>{$icon.ico_desc}</td>
                	<td><a href="">编辑</a> / <a href="">删除</a></td>
                </tr>
            {/foreach}
            <tr>
            	<td colspan="5">&nbsp;</td>
            </tr>
            <form action="./" method="post">
                <tr>
                    <td><input class="txt" type="text" name="ico_name" value="" /></td>
                    <td><input class="txt" type="text" name="ico_url" value="" /></td>
                    <td>
                        <select class="txt" name="ico_type">
                            {foreach $ico_type as $type}
                                <option value="{$type}">{$type}</option>
                            {/foreach}
                        </select>
                    </td>
                    <td><input class="txt" type="text" name="ico_desc" value="" /></td>
                    <td><input type="submit" class="sub" name="action" value="Add" /></td>
                </tr>
            </form>
        </table>
    </div>
</body>
</html>

<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="../public/css/appmarket.css" type="text/css" />
<title>应用市场</title>
</head>

<body style=" width:590px; height:400px;">
	<div class="content">
    	<div class="search">
        	<span>共有 <strong>{$total}</strong> 个应用</span>
            <form action="./appmarket.php" method="get">
                <input type="text" class="txt" name="ico_name" value="{$smarty.get.ico_name}"/>
                <input type="hidden" name="action" value="search" />
                <input type="submit" value="" class="sub" />
            </form>
        </div>
		<div class="bt">
        	<div class="bar">
                <ul>
                    {foreach $types as $type}
                    <li>
                        {if $smarty.get.icon==$type}
                            <a class="active" href="appmarket.php?icon={$type}">{$type}</a>
                        {else}
                            <a href="appmarket.php?icon={$type}">{$type}</a>
                        {/if}
                    </li>
                    {/foreach}
                </ul>
            </div>
            <div class="fr">
                <div class="info">
                    <table>
                        {foreach $icons as $icon}
                            <tr>
                                <td class="i"><span class="ri"></span><img src="../public/images/icon/{$icon.ico_name}.png" alt="" /></td>
                                <td class="d">
                                    <span class="n">{$icon.ico_name}</span>
                                    <span class="d">描述：
                                        {if $icon.ico_desc==''}
                                            暂无
                                        {else}
                                            {$icon.ico_desc}
                                        {/if}
                                    </span>
                                </td>
                                <td>
                                	{if !{isExist ico_name=$icon.ico_name}}
                                        <a class="add" href="javascript:void(0)" onClick="sendRequest('add', '{$icon.ico_name}', '{$icon.ico_url}', this)"></a>
                                    {else}
                                        <span style="color:red; font-size:12px">已添加</span>
                                    {/if}
                                </td>
                            </tr>
                        {/foreach}
                    </table>
                </div>
                <div class="page">
                    {$pageinfo}
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="../public/js/ajax.js"></script>
    <script type="text/javascript" src="../public/js/appmarket.js"></script>
</body>
</html>

<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="keywords" content="云" />
<meta name="description" content="在线云App演示，`{$smarty.const.SNAME}`，专注于WEB应用、新技术的开发，致力于WEB安全性研究，推动开源，推动网络安全。" />
<title>{$smarty.const.SNAMET} - {$smarty.const.SNAME}</title>
<link rel="stylesheet" type="text/css" href="public/css/index.css" />
<link rel="shortcut icon" href="public/images/index.ico" type="image/x-icon" />
</head>

<body>
	<div id="content">
   		<div class="pagelist">
        	<ul id="ulpl">
            	<li class="listli">
                	<ul id="listul">
                    	{if !$login}
                    		<li class="ico"><a href="http://yueqian.sinaapp.com"><img src="public/images/icon/WEBQQ.png" alt="" title="点击访问主页" /></a></li>
                        {else}
                        	<li class="ico"><a onClick="sepcialManage('pwdmg', 'dialog_pwd', '修改密码', 'frame/userinfo/')" href="javascript:void(0);"><img src="public/images/index.jpg" alt="" title="修改密码" /></a></li>
                        {/if}
            			<li class="active"><a class="p p1" href="javascript:void(0);"></a></li>
                        <li class="list"><a class="p p2" href="javascript:void(0);"></a></li>
                        <li class="list"><a class="p p3" href="javascript:void(0);"></a></li>
                    </ul>
                </li>
                <li class="navig"></li>
            	<li class="search"><a href="javascript:void(0);" id="sa"></a></li>
                <li class="end"></li>
            </ul>
        </div> 	
        <div id="sform">
            <input type="txt" class="txt" value="检索应用..." name="content" />
            <input type="button" name="btn" value="" class="sub"/>
        </div>
        <div class="toolbar">
        	<ul>
            	{if $login}
            		<li><a href="javascript:void(0);" onClick="sepcialManage('market', 'dialog_ket', '应用市场', 'frame/appmarket.php?icon=推荐')"><img src="public/images/icon/应用市场.png" alt=""  title="应用市场"/></a></li>
                	<li><a href="javascript:void(0);" onClick="sepcialManage('log', 'dialog_ket', '更新日志', 'frame/log.php')"><img src="public/images/icon/WEBQQ.png" alt=""  title="更新日志"/></a></li>
                    <li class="bt"><a title="主题设置" class="object" href="javascript:void(0)" onClick="sepcialManage('obmg', 'dialog_obj', '主题设置', 'frame/object.html')"></a><a title="注销" href="./?action=logout" class="logout"></a></li>
                {/if}
            </ul>
        </div>
   		<div class="page">
        	<ul id="ulp">
            	{if isset($icon1.back_img)}
            		<li class="page1" style="background-image:url(public/images/themes/{$icon1.back_img})">
                {else}
                	<li class="page1">
                {/if}
                	{foreach array_chunk($icon1.ico, 5) as $index=>$ico}
                    	<ul>
                        	{for $i=0 to count($ico)-1}
                            	<li class="listli">
                                    <div onClick="loadFrame('{$ico.$i.name}', '{$ico.$i.url}', '{$ico.$i.name}')" title="{$ico.$i.name}">
                                        <img src="public/images/icon/{$ico.$i.name}.png" alt="" />
                                        <span>{mb_substr($ico.$i.name,0,6,'utf8')}</span>
                                    </div>
                                </li>
                            {/for}
                        </ul>
                    {/foreach}
                </li>
                {if isset($icon2.back_img)}
            		<li class="page2" style="background-image:url(public/images/themes/{$icon2.back_img})">
                {else}
                	<li class="page2">
                {/if}
                	{foreach array_chunk($icon2.ico, 5) as $index=>$ico}
                    	<ul>
                        	{for $i=0 to count($ico)-1}
                            	<li class="listli">
                                    <div onClick="loadFrame('{$ico.$i.name}', '{$ico.$i.url}', '{$ico.$i.name}')" title="{$ico.$i.name}">
                                        <img src="public/images/icon/{$ico.$i.name}.png" alt="" />
                                        <span>{mb_substr($ico.$i.name,0,6,'utf8')}</span>
                                    </div>
                                </li>
                            {/for}
                        </ul>
                    {/foreach}
                </li>
                {if isset($icon3.back_img)}
            		<li class="page3" style="background-image:url(public/images/themes/{$icon3.back_img})">
                {else}
                	<li class="page3">
                {/if}
                	{foreach array_chunk($icon3.ico, 5) as $index=>$ico}
                    	<ul>
                        	{for $i=0 to count($ico)-1}
                            	<li class="listli">
                                    <div onClick="loadFrame('{$ico.$i.name}', '{$ico.$i.url}', '{$ico.$i.name}')" title="{$ico.$i.name}">
                                        <img src="public/images/icon/{$ico.$i.name}.png" alt="" />
                                        <span>{mb_substr($ico.$i.name,0,6,'utf8')}</span>
                                    </div>
                                </li>
                            {/for}
                      </ul>
                    {/foreach}
                </li>
            </ul>
        </div>
        <div class="bottomBarBg"></div>
        <div class="bottomBarBgTask"></div>
        <div id="btbar"></div>
    </div>
    
	<script type="text/javascript" src="public/js/move.js"></script>
	<script type="text/javascript" src="public/js/drag.js"></script>
	<script type="text/javascript" src="public/js/public.js"></script>
	<script type="text/javascript" src="public/js/ajax.js"></script>
	<script type="text/javascript" src="public/js/index.js"></script>
    {if !$login}
	    {include file='frame/login.html'}
    {/if}
</body>
</html>

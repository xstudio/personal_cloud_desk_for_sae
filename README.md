个人云桌面SAE版
===========================
      ╔------------------------------------------------╗
      ┆                 Power By 小笙_                 ┆
      ┆            http://www.xstudio.me               ┆
      ┆       		微博：@小笙_ 	               ┆
      ╚------------------------------------------------╝

注意：

	1、使用前请预先创建SAE Mysql。
	
	2、在mysql中导入压缩包中的yun.sql文件
	
	3、修改config/config.inc.php中网站标题、副标题等配置信息。
	
	4、项目部署完成后，会自动向数据中插入 xstudio(用户名)-xstudio(密码) 的管理账号和一些应用信息供应用仓库中查看
	
	5、config中的COMSTR请在系统上线前修改，并且更新已插入用户表中的用户密码。
	
	6、为确保系统的安全性，系统上线后请删除get_store_pwd.php文件。

-管理员可以通过admin/index.php登录后台进行应用的管理

-普通用户需要通过前台的注册、登录才能进入自己的云桌面



系统密码存储方案
===========================
	用户密码在数据库中存储为32位md5密文

	当用户登录或者注册时，提交的密码会进行处理

	$password=md5($_POST['password'].COMSTR);

	最终存储在数据库的为经过原密码和config中的COMSTR连接进行散列的32位字符串$password

	所以，在系统运行过程中COMSTR的值，最好不要改动，如果有改动的话，请更新已插入用户表中的用户密码。

	要查看原密码应该在数据库中存储的值，可以访问根目录下get_store_pwd.php?pwd=password获取（password-原密码）
	

更新日志
===========================
v3.0 2013/11/18

SAE版本托管github <a target="_blank" href="https://github.com/xstudio/personal_cloud_desk_for_sae">https://github.com/xstudio/personal_cloud_desk_for_sae</a>

local版本托管github <a target="_blank" href="https://github.com/xstudio/personal_cloud_desk_for_local">https://github.com/xstudio/personal_cloud_desk_for_local</a>

修改侧边栏主页链接为change log链接

优化首次登陆显示的应用

优化部分应用图标

优化底部图标点击修改对应层级为最大

------------------------------------------------------

v2.0 2013/11/01

侧边栏主页链接图标尺寸更换，兼容火狐

顶部banner链接图标尺寸更换，兼容火狐

顶部搜索JS优化

应用仓库搜索优化

多个应用窗口点击时修改对应层级为最大

------------------------------------------------------

v1.0 2013/03/28

普通用户登录/注册/注册智能提示

用户首次登录默认桌面1，并默认添加6个应用

左侧边栏上部显示应用仓库/作者主页两个链接

左侧边栏下部显示主题设置/注销两个链接

顶部导航显示修改密码/三个页面切换/应用搜索

桌面切换动态效果

应用仓库显示不同类别应用/应用是否被添加

切换到对应桌面(1/2/3)，打开左侧边栏/右键菜单应用仓库添加应用

点击桌面/侧边栏应用直接在当前桌面打开应用

打开应用的最大化/最小化/中等尺寸/关闭

打开应用在底部显示小图标，点击可显示/隐藏，右键可关闭

切换到对应桌面(1/2/3)，打开左侧边栏/右键菜单设置桌面主题

点击顶部搜索按钮，输入应用标题搜索应用

桌面右键菜单快捷键(刷新/应用仓库/设置主题)

用户退出后保存用户添加的应用，下次登录时可恢复

后台管理员登录(/admin/)/退出

后台应用列表/不同类别应用的添加

兼容IE9以上/FF/Chrome等高版浏览器


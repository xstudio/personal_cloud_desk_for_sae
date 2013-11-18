-- CREATE DATABASE `yun` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
CREATE TABLE `yun_icon`(
    `ico_id` mediumint unsigned AUTO_INCREMENT PRIMARY KEY COMMENT 'ID',
    `ico_name` varchar(20) NOT NULL COMMENT 'ICO名称',
    `ico_url` varchar(150) NOT NULL COMMENT 'ICO链接',
    `ico_type` varchar(20) NOT NULL COMMENT 'ICO类别',
    `ico_desc` varchar(255) COMMENT 'ICO描述'
)ENGINE=MyISAM DEFAULT CHARSET=UTF8;

INSERT INTO `yun_icon` (`ico_id`, `ico_name`, `ico_url`, `ico_type`, `ico_desc`) VALUES
(NULL, '凤凰资讯', 'http://news.ifeng.com/', '新闻', NULL),
(NULL, '新浪资讯', 'http://news.sina.com.cn', '新闻', NULL),
(NULL, '百度资讯', 'http://news.baidu.com/', '新闻', NULL),
(NULL, '3366', 'http://www.3366.com/', '游戏', NULL),
(NULL, '新浪微博', 'http://weibo.com/', '社交', NULL),
(NULL, 'QQ空间', 'http://qzone.qq.com/', '社交', NULL),
(NULL, '体育导航', 'http://123.sports.cntv.cn/daohang.html', '体育', NULL),
(NULL, '起点中文', 'http://www.qidian.com/Default.aspx', '读书', NULL),
(NULL, '漫画盒子', 'http://www.manmankan.com/', '读书', NULL),
(NULL, '豆瓣FM', 'http://douban.fm/', '音乐', NULL),
(NULL, '百度音乐盒', 'http://play.baidu.com/', '音乐', NULL),
(NULL, '酷狗', 'http://web.kugou.com/default.html', '音乐', NULL),
(NULL, '土豆', 'http://www.tudou.com', '视频', NULL),
(NULL, '优酷', 'http://www.youku.com', '视频', NULL),
(NULL, '爱奇艺', 'http://www.iqiyi.com/', '视频', NULL),
(NULL, 'WEB程序员手册', 'http://yueqian.sinaapp.com/app/webdevelope/', '推荐', NULL),
(NULL, '百度地图', 'http://yueqian.sinaapp.com/app/dumap/dumap.html', '推荐', NULL),
(NULL, '在线PS', 'http://pixlr.com/', '工具', NULL);

CREATE TABLE `yun_user`(
    `user_name` varchar(20) PRIMARY KEY NOT NULL COMMENT '用户名',
    `user_pwd` varchar(32) NOT NULL COMMENT '用户密码',
    `user_mail` varchar(50) COMMENT '邮箱',
    `user_sex` char(1) COMMENT '性别',
    `user_birth` int unsigned COMMENT '出生年月',
    `user_address` varchar(30) COMMENT '住址',
    `user_website` varchar(150) COMMENT '个人站点',
    `user_admin` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否是管理员'
)ENGINE=MyISAM DEFAULT CHARSET=UTF8;

INSERT INTO `yun_user` (`user_name`, `user_pwd`, `user_mail`, `user_sex`, `user_birth`, `user_address`, `user_website`, `user_admin`) VALUES
('xstudio', 'd6481bcff2b7be83695c0022dda32feb', NULL, NULL, NULL, NULL, NULL, 1);

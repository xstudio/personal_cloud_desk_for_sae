CREATE DATABASE `yun` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
CREATE TABLE `yun_icon`(
    `ico_id` mediumint unsigned AUTO_INCREMENT PRIMARY KEY COMMENT 'ID',
    `ico_name` varchar(20) NOT NULL COMMENT 'ICO名称',
    `ico_url` varchar(150) NOT NULL COMMENT 'ICO链接',
    `ico_type` varchar(20) NOT NULL COMMENT 'ICO类别',
    `ico_desc` varchar(255) COMMENT 'ICO描述'
)ENGINE=MyISAM DEFAULT CHARSET=UTF8;
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

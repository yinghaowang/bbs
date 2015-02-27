<?php
/*** ROCBOSS V1.1 Beta 配置文件 ***/

//数据库配置项
$db_config = array(
				'db_host' => 'localhost',
				'db_user' => 'root',
				'db_pass' => 'root',
				'db_name' => 'rocboss',
				'db_pre'	=>	'roc_',
				'db_code' => 'utf8',
				'db_switch' => 	'true',
				'db_long'	=>	'false'
				);

//常规配置项
$roc_config = array(
	'sitename'	=> '毕业设计',			// *网站名称
	'siteicp'	=> 'B11070210',			//  网站备案号
	'smtp'		=> '',						//  系统smtp服务器
	'sitemail'	=> '', 						//  系统邮箱地址
	'mailpwd'	=> '',						//  系统邮箱密码
	'version'	=> 'V1.1',					//  系统当前版本
	'emailjoin'	=> 1,						// *是否允许用户注册, 1 允许 , 0 禁止
	'secure_key'=> '&%cs50sd#fr2014',		// *网站密钥,不少于12位
	'lock_mod'	=> '0',						// *本站私密版块ID，多个用 , 隔开，默认留 0
);

//用户组配置项
$group_config = array(
    '0' => '禁言用户',
    '1' => '一级会员',
    '2' => '二级会员',
    '3' => '三级会员',
    '4' => '社区元老',
    '5' => '待扩展用户组',
    '6' => '待扩展用户组',
    '7' => '待扩展用户组',
    '8' => '管理员',
    '9' => '站长'
);

//金币配置项
$balance_config = array(
	'type'	=> array(
		'0' => '系统调整',
		'1'	=> '注册奖励',
		'2' => '登录奖励',
		'3'	=> '发表话题',
		'4' => '发表回复',
		'5' => '话题被删',
		'6' => '回复被删',
		'7' => '传送私信',
		'8' => '微文被赞',
		'9' => '取消赞'
	),
	'change'	=> array(
		'register'	=> '20',			// 注册赠送金币
		'login'		=>  rand(1,10),		// 登录赠送金币
		'topic'		=> '2',				// 发表话题金币
		'reply'		=> '1',				// 发表回复金币
		'commend'	=> '1',				// 赞奖励金币
		'whisper'	=> '-5', 			// 传送私信金币
	)
);

//模板配置项(默认无需修改)
$tpl_config=array(
	'tpl_dir'	=>	'rocboss', 			//设置模板目录
	'tpl_ext'	=>	'.tpl',  			//设定模板后缀
	'tpl_cache'	=> 	'themes', 			//模板编译目录
	'tpl_time'	=>	'0' 				//缓存生命周期  单位秒, 0是每次都重新编译, -1是永不过期
);

//QQ互联插件配置项，需到 http://connect.qq.com/ 申请
$qq_config = array(
	'appid' => '',  // APPID
	'appkey'=> ''	// APPKEY
);


?>
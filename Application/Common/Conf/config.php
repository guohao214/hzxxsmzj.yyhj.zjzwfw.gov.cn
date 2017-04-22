<?php
return array(
	//'配置项'=>'配置值'

    'DB_TYPE' => 'mysql', // 数据库类型

    'DB_HOST' => '183.129.131.136', // 服务器地址

    'DB_NAME' => 'smzj', // 数据库名

    'DB_USER' => 'root', // 用户名

    'DB_PWD' => 'adminuser', // 密码

    'DB_PORT' => '8887', // 端口

    'DB_PREFIX' => 'his_', // 数据库表前缀

    'TMPL_L_DELIM' => '<{', //定义左定界符

    'TMPL_R_DELIM' => '}>', //定义右定界符

    'MODULE_ALLOW_LIST' => array(
        'Home'
    ),

    'DEFAULT_MODULE' => 'Home',// 配置你原来的默认分组

    'URL_MODEL' => 1, //重写隐藏index.php
);

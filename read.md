伪静态部署：
1、apache：将目录中htaccess更名成 .htaccess即可
2、Nginx：
  location / { // …..省略部分代码
   if (!-e $request_filename) {
   rewrite  ^(.*)$  /index.php?s=$1  last;
   break;
    }
 }


以上部署可以参照
	http://www.kancloud.cn/manual/thinkphp/1866
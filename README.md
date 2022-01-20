# new-year-couplet
### 生成对联图片的Python程序来自[CSDN-天元浪子: 用Python写春联：抒写最真诚的祝福和最美好的祈愿](https://blog.csdn.net/xufive/article/details/104059396?ops_request_misc=%257B%2522request%255Fid%2522%253A%2522164241285616780261921494%2522%252C%2522scm%2522%253A%252220140713.130102334..%2522%257D&request_id=164241285616780261921494&biz_id=0&utm_medium=distribute.pc_search_result.none-task-blog-2~all~top_yy~default-1-104059396.first_rank_v2_pc_rank_v29&utm_term=%E4%BB%A3%E7%A0%81%E5%86%99%E6%98%A5%E8%81%94&spm=1018.2226.3001.4187)

## 遇到的问题
### 1、PHP 没有 Redis 模块（我用的是 php7.4.26）
* 1.1、下载并安装redi扩展
```shell
	wget http://pecl.php.net/get/redis-5.3.4.tgz
	tar -zxvf redis-5.3.4.tgz
	cd redis-5.3.4
	phpize
```
* 运行phpize的时候如果报错 `Cannot find autoconf. Please check your autoconf installation and the $PHP_AUTOCONF environment variable. Then, rerun this script.`
	* 解决方法：运行 `yum -y install autoconf`

### 2、在网站上使用php后台执行python代码不成功
* 2.1、nginx 报错failed (13: Permission denied)
	* 解决： 编辑 `/etc/selinux/config` 文件，把 `SELINUX=enforcing` 修改为 `SELINUX=permissive`

### 3、web传入的对联文本怎么传递给 python 脚本进行处理(通过操作redis来实现)
* 3.1、可行的解决方法
	* 3.1.1、用 php 把对联信息写入到 redis，python 脚本读取 redis 的方法。python 操作redis没有报错，这种方法可行
* 3.2、不可行的方法
	* 3.2.1、使用 php 中的 `exec` 函数直接执行 `exec(python $path/67dae39b5fd98555aebc2119e9e2ca6a.py "对联内容")`，但是web端操作php来执行 python，是没有权限调用 python 中的 `sys` 模块。
	* 3.2.2、通过中间文件来传递 `对联内容`：第一步先通过 php 把对联写入中间文本 `text.txt` 文件，然后在执行 python 文件来读取 `text.txt`，从而获取对联内容。但是这样操作 python 也没有权限来读取 `text.txt`。

### 4、网站目录所有者需要修改成当前网站运行的用户
* 4.1、在 `/etc/nginx/nginx.conf` 中查找运行网站的用户（我的是 `user  nginx nginx;`，即为nginx）
* 4.2、修改网站的所有者 chown -R root:nginx [网站目录]
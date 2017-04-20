---
title: Ubuntu14.04完美服务器配置
date: 2017-01-8 15:49:44
category: 服务器
tags:
  - Ubuntu14
  - 服务器设置
  - LAMP
  - Linux

---

我使用 Vultr 的机器，他家的机器性价比高，宽带速度大，SSD 硬盘性能好，非常不错，我的三台机器都在 Vultr 上。

这是我的[推荐链接](http://www.vultr.com/?ref=6857391)。

这是我的[专属活动链接](http://www.vultr.com/?ref=6916704-3B)，从这里注册你能得到20美元的优惠。

现在分享一下我的基于Ubuntu14.04的完美服务器方案，此方案是我的所有服务器的标准配置，非常好用，屡试不爽。为了安全，密码全部替换成了123456.如果你参考这里配置自己的服务器，请注意修改。

<!--more-->

### 注意：
(1)配置好后，不重启，不关机
(2)重要文件修改前一定要备份


### 概要：
(1)机器系统版本：Ubuntu 14.04 x64
(2)机器主要服务：Shadowsocks，HTTP,  PHP，MySQL，Node JS，Tomcat, Java, Git，SVN，Email，PhantomJS，Go，MongoDB，C/C++，redis

### 备注：
(1)额外软件安装目录：/opt
(2)web 目录：/var/www

### 常用命令：
(1)启动 Shadowsocks:

```bash
nohup ssserver -c /etc/shadowsocks.json -d start
```

(2)停止Shadowsocks：

```bash
ssserver -c /etc/shadowsocks.json -d stop
```

(3)重新启动 apache：

```bash
etc/init.d/apache2 restart
```

(4)启动 tomcat：

```bash
/opt/apache-tomcat-8.0.38/bin/startup.sh
```

(5)停止 tomcat:

```bash
/opt/apache-tomcat-8.0.38/bin/shutdown.sh
```

(6)查看 shadow socks的流量统计：

```bash
iptables -vnL
```


### 服务器配置：

#### 1.用初始密码登录

#### 2.更改密码:

```bash
passwd root
```

更改为 123456

#### 3.更新：

```bash
apt-get update
```

#### 4.安装 vim:

```bash
apt-get install vim
```

#### 5.修改 locale:

```bash
vim /etc/default/locale
```

修改为：

```bash
LANG="en_US.UTF-8"
LANGUAGE="en_US.UTF-8"
LC_ALL="en_US.UTF-8"
```

(2)先 logout ，再 login，这时候前面设置的 locale 才能生效

#### 6.安装 unzip:

```bash
apt-get install unzip
```

#### 7.安装 git:

```bash
apt-get install git
```

#### 8.安装 svn:

```bash
apt-get install subversion
```

#### 8.安装 shadow socks:

```bash
apt-get install python-gevent python-pip
pip install shadowsocks
apt-get install python-m2crypto
```

新建配置文件

```bash
vim /etc/shadowsocks.json
```


启动服务器：

```bash
nohup ssserver -c /etc/shadowsocks.json -d start
```

#### 9.一次性添加流量统计监控端口:

```bash
vim listen.sh
```

新建文件：

```bash
#!bin/bash
for i in $( seq 2000 2100 )
do
    iptables -A OUTPUT -p tcp --sport $i && iptables -A INPUT -p tcp --dport $i
done
```

执行这个脚本，添加监控：

```bash
/bin/bash listen.sh
```

执行查看流量统计：

```bash
iptables -vnL
```

#### 10.安装 lamp:

```bash
apt-get install apache2
apt-get install php5
apt-get install php5-cli
apt-get install php5-gd   
apt-get install mysql-server   密码 930102@my
apt-get install mysql-client
apt-get install php5-mysql
```
提示：gd 为图形库，二维码绘制需要

#### 11.设置 apache:

```bash
vim /etc/apache2/apache2.conf
```

增加全局配置，添加如下行：

```bash
ServerName localhost
```

编辑虚拟机配置：

```bash
vim /etc/apache2/sites-available/000-default.conf
```

修改为：

```bash
<VirtualHost *:80>
       ServerAdmin postmaster@leiquan.me
       DocumentRoot /var/www
       ErrorLog ${APACHE_LOG_DIR}/error.log
       CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
<VirtualHost *:80>
       ServerName leiquan.me
       ServerAlias *.leiquan.me
       ServerAdmin postmaster@leiquan.me
       DocumentRoot /var/www/leiquan.me
       ErrorLog ${APACHE_LOG_DIR}/leiquan.me/error.log
       CustomLog ${APACHE_LOG_DIR}/leiquan.me/access.log combined
</VirtualHost>
```

创建日志目录,每个站的日志分开存放：

```bash
mkdir /var/log/apache2/leiquan.me/
```

#### 12.安装 phpmyadmin到/var/www:

```bash
wget https://files.phpmyadmin.net/phpMyAdmin/4.6.4/phpMyAdmin-4.6.4-all-languages.zip
unzip phpMyAdmin-4.6.4-all-languages.zip
```

#### 13.克隆各个代码库，然后重启 apache：

```bash
/etc/init.d/apache2 restart
```

#### 14.安装 node:
(1)下载 node 的 linux 二进制文件到/opt：

```bash
wget https://nodejs.org/dist/v6.8.0/node-v6.8.0-linux-x64.tar.xz
tar -xvf node-v6.8.0-linux-x64.tar.xz
```

(2) 编辑环境变量：

```bash
vim /etc/profile
```

末尾加上：

```bash
# Node JS
export NODE_HOME=/opt/node-v6.8.0-linux-x64
export PATH=$PATH:$NODE_HOME/bin
export NODE_PATH=$NODE_HOME/lib/node_modules
```

(4)使之生效：

```bash
source /etc/profile
```

(5)检测生效：

```bash
node -v
npm -v
```


#### 15.接下来安装 JDK 设置环境变量：
(1)从JDK官网下载linux64.tar.gz,注意其下载地址是要每次去官网上获得的，并且注意改名改后缀

或者从本地上传到/opt

(2)解压移动到/opt：tar -zxvf

(3)接着添加环境变量：

```bash
vim /etc/profile
```

(4)结尾添加如下：

```bash
# Java
JAVA_HOME=/opt/jdk1.8.0_112
PATH=$JAVA_HOME/bin:$PATH
CLASSPATH=$JAVA_HOME/jre/lib/ext:$JAVA_HOME/lib/tools.jar:/opt/apache-tomcat-8.0.38/lib/servlet-api.jar
export PATH JAVA_HOME CLASSSPATH
```

(5)使之生效：

```bash
source /etc/profile
```

(6)检测生效：

```bash
echo $JAVA_HOME
```

#### 16.安装 Tomcat8，8.0.38的版本的设置比较简单，8.5.6的设置太复杂了，非本机无法登录管理员，配置如下：
(1)官网下载安装文件:

```bash
wget http://mirrors.cnnic.cn/apache/tomcat/tomcat-8/v8.0.38/bin/apache-tomcat-8.0.38.tar.gz
```

(2)解压移动到/opt:

```bash
tar -zxvf   apache-tomcat-8.0.38.tar.gz
```

(3)编辑管理员：

```bash
vim /opt/apache-tomcat-8.0.38/conf/tomcat-users.xml
```

标签内新增：

```bash
<role rolename="manager-gui"/>
<role rolename="admin-gui"/>
<user username="root" password="930102@root" roles="manager-gui, admin-gui"/>
```

(4)操作Tomcat服务器，重启实在太慢，请耐心等待：

```bash
/opt/apache-tomcat-8.0.38/bin/startup.sh
/opt/apache-tomcat-8.0.38/bin/shutdown.sh
```

(5)注意,默认端口为：8080：

#### 17.安装 PhantomJS：
(1)下载到/opt:

```bash
wget https://bitbucket.org/ariya/phantomjs/downloads/phantomjs-2.1.1-linux-x86_64.tar.bz2
```

或者本地上传
(2)解压：

```bash
tar -jxvf phantomjs-2.1.1-linux-x86_64.tar.bz2
```

(3)设置环境变量：

```bash
vim /etc/profile
```

写入环境变量：

```bash
#PhantomJS
export PATH=/opt/phantomjs-2.1.1-linux-x86_64/bin:$PATH
```

(4)使环境变量生效：

```bash
source /etc/profile
```

(5)添加依赖包：

```bash
sudo apt-get install libfontconfig1
phantomjs --version
```

#### 18.安装go语言：
(1). 下载到/opt:

```bash
wget https://storage.googleapis.com/golang/go1.7.3.linux-amd64.tar.gz
```

(2).解压：

```bash
tar -zxvf go1.7.3.linux-amd64.tar.gz
```

(3).配置环境变量：

```bash
vim /etc/profile
```

加入环境变量：

```bash
#Go Lang
export GOROOT=/opt/go
export GOBIN=/opt/go/bin
export PATH=$PATH:$GOBIN
```

(4).使之生效：

```bash
source /etc/profile
```

(5).验证：

```bash
go version
```

#### 19.安装 mongoDB:
(1)下载到 /opt：

```bash
wget https://fastdl.mongodb.org/linux/mongodb-linux-x86_64-ubuntu1404-3.2.10.tgz
```

(2)解压：

```bash
tar -zxvf mongodb-linux-x86_64-ubuntu1404-3.2.10.tgz
```

(3)环境变量：

```bash
vim /etc/profile
```

添加：

```bash
#MongoDB
export PATH=/opt/mongodb-linux-x86_64-ubuntu1404-3.2.10/bin:$PATH
```

(5)使环境变量生效：

```bash
source /etc/profile
```

(4)设置数据库目录：

```bash
mkdir -p /data/db
```

(6)启动：(参数是两个短横杠)

```bash
mongod
```

如果是启动有web 界面的服务端：

```bash
mongod --rest  --httpinterface
```

或者加 &保持在后台运行

MongoDB 的 Web 界面访问端口比服务的端口多1000。
如果你的MongoDB运行端口使用默认的27017，你可以在端口号为28017访问web用户界面
(7)登录数据库管理数据：

```bash
mongo
```

(8)退出：

```bash
quit()
```

#### 20.安装c和c++支持：

```bash
apt-get install build-essential
```

#### 21.安装redis：

```bash
apt-get install redis-server
```

验证：

```bash
redis-server -v
```

(3) 配置文件位置：/etc/redis

#### 22.邮件服务器：（终于成功了，之前是因为 vultr 屏蔽了25端口）
首先要做 mx 记录

MX记录
host:@
value: leiquan.me
priority:1

安装 postfix：

```bash
apt-get install postfix
```

选择 internet
输入 leiquan.me

安装邮件组件：

```bash
apt-get install mailutils
```

(3)添加用户：

```bash
useradd -m -s /bin/bash postmaster
passwd postmaster
```
密码为：123456

(4)编辑转发，这是在本地用户收到了邮件后转发到指定收件箱：

```bash
vim /etc/aliases
```

注释掉默认的 postmaster添加：
postmaster: leiquan@live.com
重新载入：

```bash
newaliases
```

(5)设置主机名：

```bash
vim /etc/hosts
```

添加：

```bash
127.0.0.1 leiquan.me
```

运行：

```bash
hostname leiquan.me
```

(6)配置 postfix:

```bash
vim /etc/postfix/main.cf
```

增加一行设置收件箱风格和地址：

```bash
home_mailbox = Maildir/
```

此设定将邮件放在用户的目录的Maildir目录下面

(7)重启:

```bash
/etc/init.d/postfix restart
```

(8)发送测试邮件：

```bash
echo "邮件正文" | mail -s "标题" postmaster
```

这时候应该在邮箱就可以收到邮件了，测试均可以正常收到，没有的话查看垃圾箱，并且回复也可以收到，在 Maildir 文件夹内

常用命令：
邮件队列管理：
#postqueue -p查看邮件队列
如果队列序号加了*号表示为活动队列
如果队列序号加了!号表示为延期队列
如果队列序号没有*与!号表示为等待队列
#postsuper -d DBA3F1A9删除队列里的邮件
#postsuper -d ALL删除队列里所有的邮件
#postsuper -r ALL重新排队所有邮件
#postcat -q DBA3F1A9查看邮件内容

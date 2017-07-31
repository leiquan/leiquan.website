---
title: MySQL忘记密码
date: 2017-07-30 23:42:04
category: 服务器
tags:
  - 数据库
  - MySQL
  - 网络安全
---

为什么老是忘记了 MySQL 的密码呢，这是病，得治。我之前记在了备忘录中，但是还是不对，应该是中间被改过一次。

在自己网站上记一下，不然每次都得翻一遍。


#### 服务器环境：ubuntu 14.10 X64

<!--more-->

#### 1.关掉权限：

修改配置文件：

```bash
sudo vim /etc/MySQL/my.cnf
```

在[mysqld]字段中加入一行：

```bash
skip-grant-tables
```

#### 2.重启mySQL服务：

```bash
sudo service mysql restart
```

#### 3.用空密码进入mysql管理命令行：

```bash
sudo mysql -u root -p
```
密码直接 enter。

#### 4.进入 mysql 数据库：

```bash
use mysql;
```

mysql 命令是分号结尾的。

#### 5.设置密码：

```bash
update user set password=password('123456') where user='root';
```
括号里为你要修改的密码。

#### 6.刷新权限：

```bash
flush privileges;
```

#### 7.退出：

```bash
quit
```

#### 8.重复第一步，将那一行去掉或者注释掉即可。

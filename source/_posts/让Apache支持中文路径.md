---
title: 让Apache支持中文路径
date: 2017-02-01 01:39:04
category: 服务器
tags:
  - 服务器设置
  - LAMP
  - Linux
  - Apache
---

环境：Ubuntu14.04

默认，Apache 是不支持中文路径的，如果需要支持，其实很简单。

<!--more-->

1.安装模块

```bash
apt-get install libapache2-mod-encoding
```

2.在 apache.conf配置文件添加如下配置：

```bash
<IfModule mod_headers.c>
    Header add MS-Author-Via 'DAV'
</IfModule>
<IfModule mod_encoding.c>
    EncodingEngine on
    NormalizeUsername on
    SetServerEncoding GBK
    DefaultClientEncoding UTF-8 GBK GB2312
    AddClientEncoding '(Microsoft .* DAV $)' UTF-8 GBK GB2312
    AddClientEncoding 'Microsoft .* DAV' UTF-8 GBK GB2312
    AddClientEncoding 'Microsoft-WebDAV*' UTF-8 GBK GB2312
</IfModule>
```


3.最后重启服务器即可：

```bash
/etc/init.d/apache2 restart
```

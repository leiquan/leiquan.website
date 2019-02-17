---
title: PHP json_last_error 错误码3解决方案
date: 2019-02-18 02:13:21
category: 服务器
tags:
  - PHP
  - 服务器
---

一个跑了两年多的服务，从 PHP 5 迁移到了 PHP7，换了个环境就报错了。

以前的 json_decoe 就有问题了，返回了 null。

出现问题后，首先使用 json_last_err来定位错误原因，得到了错误码为3。

<!--more-->

根据其错误码定义：

    0 = JSON_ERROR_NONE

    1 = JSON_ERROR_DEPTH

    2 = JSON_ERROR_STATE_MISMATCH

    3 = JSON_ERROR_CTRL_CHAR
  
    4 = JSON_ERROR_SYNTAX
    
    5 = JSON_ERROR_UTF8

控制字符错误，可能是编码错误，或者文件里有 bom 头等原因。

那么我们可以删除所有的不可打印字符：

```php
$string = '{'.$data->data[$i]->detail.'}';
$string =  preg_replace('/[\x00-\x1F\x80-\x9F]/u', '', trim($string));
$detail = json_decode($string);
```

即可。

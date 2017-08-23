---
title: 为网站设置HTTPS
date: 2017-01-01 12:39:04
category: 服务器
tags:
  - Apache
  - 服务器设置
  - HTTPS
  - 网络安全
---
我们知道，现在几乎所有的大型网站，比如谷歌，百度等，都已经启用了全栈 HTTPS，用了 HTTPS 之后，不仅访问的时候安全性有保障，而且地址栏绿色的“安全“提示也很酷炫很让人放心。所以，咱们作为个人站长，当然也要跟上时代潮流啊。然而很不幸，HTTPS  的SSL证书通常是要钱的，并且价格不菲，因为毕竟别人给你干活发证书了嘛。

然而互联网总是很神奇，很多优秀，很有价值的东西，通常能够免费获得。Let's encrypt 就是今天的主角。

<!--more-->

以下为基本步骤：

首先，你需要克隆这个项目到你的机器：

```bash
git clone https://github.com/letsencrypt/letsencrypt  && cd letsencrypt && ./letsencrypt-auto
```

然后，根据提示，一步步的来，最后我们看到了类似的提示，就是成功了：

```bash
Your certificate and chain have been saved at /etc/letsencrypt/live/leiquan.me/fullchain.pem
```


接下来，我们需要修改 apache，在 http 的虚拟主机下设置配置这三项，注意 https 的端口是443而不是80：

```bash
SSLEngine on
SSLCertificateFile /etc/letsencrypt/live/leiquan.website/cert.pem
SSLCertificateChainFile /etc/letsencrypt/live/leiquan.website/fullchain.pem
SSLCertificateKeyFile /etc/letsencrypt/live/leiquan.website/privkey.pem
```

然后重启服务器，就能通过 https://leiquan.me 来访问了，档次立马提升了有木有啊！

这个的配置是非常简单的，但是要注意的是：本证书只有90天，到期后需要更新证书并重启服务器，然而，庆幸的是，你也可以设置自动续费。

如果你之前有把你的 http 域名分享出去，那么可以设置重定向，让 apache 强制 https 访问：

我们需要启动 rewrite module：

```bash
a2enmod rewrite
```

然后编辑 /etc/apache/sites-available/000-default.conf,在 http 对应的虚拟机下添加:

```bash
RewriteEngine on
RewriteCond   %{HTTPS} !=on
RewriteRule   ^(.*)  https://%{SERVER_NAME}$1 [L,R]
```

便可以将 http 强制跳转到https。

最后重启服务器即可：

```bash
/etc/init.d/apache2 restart
```

由于证书的有效期只有3个月，每三个月需要续期一次：

```bash
./letsencrypt-auto renew
```
然后重启服务器即可。

如果是 nginx 服务器，可以这样设置：
```bash
server {
        listen       443 ssl;
        server_name  your.website;

        ssl_certificate      /etc/letsencrypt/live/your.website/fullchain.pem;
        ssl_certificate_key  /etc/letsencrypt/live/your.website/privkey.pem;

        ssl_protocols TLSv1 TLSv1.1 TLSv1.2;
        ssl_ciphers AES256+EECDH:AES256+EDH:!aNULL;
        ssl_prefer_server_ciphers  on;

        location / {
            ...，这里是你的原来的设置
        }
    }
```

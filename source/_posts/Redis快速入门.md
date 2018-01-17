---
title: Redis快速入门
date: 2018-01-16 00:46:00
category: 服务器
tags:
  - 数据库
---

作为一名程序员，当然是听说过 Redis 多年了，但是一直没有好好的学习他一下。我想，作为一个有几年经验的开发人员，并且熟悉 MySql，应该很快就能入门，因此今晚准备花50分钟来入门它------50分钟后就是凌晨两点，该睡觉了，不想背单词，就学技术吧。

技术这种东西，入门一个，头脑里就少一个黑洞...先入门，再择需深入，是我的学习路径。

<!--more-->

#### 一、安装

```shell
apt-get install redis-server
```

#### 二、启动 Redis

```shell
redis-server
```
启动的过程中，发现报了个警告：
```shell
WARNING overcommit_memory is set to 0! Background save may fail under low memory condition. To fix this issue add 'vm.overcommit_memory = 1' to /etc/sysctl.conf and then reboot or run the command 'sysctl vm.overcommit_memory=1' for this to take effect.
```

再次启动，便没有问题了，为了后台运行，加 nohup 和 &，端口为6379。

#### 三、数据类型

1. String（字符串）

    string是redis最基本的类型，你可以理解成与Memcached一模一样的类型，一个key对应一个value。

    string类型是二进制安全的。意思是redis的string可以包含任何数据。比如jpg图片或者序列化的对象 。

    string类型是Redis最基本的数据类型，一个键最大能存储512MB。

2. Hash（哈希）

    Redis hash 是一个键值(key=>value)对集合。

    Redis hash是一个string类型的field和value的映射表，hash特别适合用于存储对象。

    每个 hash 可以存储 232 -1 键值对（40多亿）

3. List（列表）

    Redis 列表是简单的字符串列表，按照插入顺序排序。你可以添加一个元素到列表的头部（左边）或者尾部（右边）。

    列表最多可存储 232 - 1 元素 (4294967295, 每个列表可存储40多亿)。

4. Set（集合）

    Redis的Set是string类型的无序集合。
    
    集合是通过哈希表实现的，所以添加，删除，查找的复杂度都是O(1)。

5. zset(sorted set：有序集合)
    Redis zset 和 set 一样也是string类型元素的集合,且不允许重复的成员。

    不同的是每个元素都会关联一个double类型的分数。redis正是通过分数来为集合中的成员进行从小到大的排序。

    zset的成员是唯一的,但分数(score)却可以重复。

#### 四、发布订阅

发布订阅模式作为程序员很熟悉，只是好奇在数据库里竟然实现了这个，以前并不知道。看一下.

```shell
redis-cli

SUBSCRIBE redisChat

```

新开一个终端连接 Redis，发布订阅：

```shell
redis-cli

PUBLISH redisChat "Hello, world!"

```

之前的一个终端便受到了消息。

如果用 Node.JS 的话，则可以用 ioredis 来实现方便的操作。甚至实现简单的聊天室，涨姿势了，之前一直认为聊天室需要 Socket 编程的，参考资料2和3。真·特色功能。这一块儿需要写个 demo 感受一下。

#### 五、事务

事务基本概念就没有什么好说的了，保证原子性的批量操作，但是也有不少东西需要学习。参考资料4.

#### 六、消息队列

因为 Redis 在内存里，所以非常的快。因此 Redis 用来缓存任务是非常的好。参考资料5，一个简单的模型。但是这个模型的问题是仅仅适用于不需要返回值的模型。

我搜了下，搜到了参考资料6，答者的分析很好。

    "最后再来看题主的需求，是希望先写Redis，再异步同步到mysql里面，期望数据的最终一致性。这样带来的好处是前端写的请求飞速啊(不用落盘当然快)，问题是很复杂，而且不太合理。假设是合理的话，就应该选择一个更可靠的消息中间件，比如Redis作者开源的Disque，或者阿里开源RocketMQ，以及基于Golang的nsq等，Redis更适合用来存数据。"

所以我来看一下Disque以及同事提到的卡夫卡。完了，已经超时10分钟了，看来是要下次接着学的节奏。

一小时快速入门到此为止。睡觉。


---

#### 参考资料：

1.[Redis系列(三)：Redis发布订阅及客户端编程------CSDN](http://blog.csdn.net/guoduhua/article/details/55102403)

2.[ioredis------npm.js](https://www.npmjs.com/package/ioredis)

3.[基于订阅/发布模式的简易聊天室实现（java+redis）](http://blog.csdn.net/zfy1355/article/details/50963964)

4.[Redis 事务](http://www.runoob.com/redis/redis-transactions.html)

5.[【高并发简单解决方案】redis队列缓存 + mysql 批量入库 + php离线整合](https://segmentfault.com/a/1190000004136250)

6.[redis怎么做消息队列?](https://www.zhihu.com/question/20795043)

7.[Kafka，Mq，Redis作为消息队列使用时的差异](https://www.zhihu.com/question/43557507?sort=created)


8.[kafka入门：简介、使用场景、设计原理、主要配置及集群搭建（转）](https://www.cnblogs.com/likehua/p/3999538.html)

9.[总结：如何使用redis缓存加索引处理数据库百万级并发](https://www.cnblogs.com/fanwencong/p/5782860.html)

10.[用Redis轻松实现秒杀系统](http://blog.csdn.net/shendl/article/details/51092916)





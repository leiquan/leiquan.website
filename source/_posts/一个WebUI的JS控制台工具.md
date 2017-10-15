---
title: 一个WebUI的JS控制台工具
date: 2017-10-15 19:56:04
category: Web前端
tags:
  - 控制台
  - JavaScript
---

上周五面试，和面试官在电话里说到，我写了个用于在 Chrome 控制台没法用的时候调试 JS 的控制台小工具。

然后他问我怎么实现的，我给忘了，因为这几次面试比较着急，根本没看代码，一年多了，啥都忘了，我记性这么差...而且，这两天的奇葩经历让我更没时间去复习了...

然后，我让他到我的 Github 上看看去...

但是这个代码当时不在我的名下，在 BEFE 组织里；这下，明明是我做的，也变成不是我做的了，我真没骗你...

截图什么的我懒得贴了，在我 [2016职称评定的 PPT](/resource/2016职称评定-雷全.pdf)里面有截图的，

<!--more-->

这个小东西是因为当时我们开发的 Windows 版本的百度 Hi 的时候，没法用控制台调试，所以带来了一些麻烦，我网上看了下，有两个类似的工具，但是没啥好用的。就自己搞了个，主要就是简单的实现了控制台的基本功能了。

Github 代码在这里：[JSUILogger](https://github.com/be-fe/JSUILogger/)。

核心代码如下：

```JavaScript

// 核心代码块1
// 处理输入
JSUILogger.prototype.input = function (value) {

        // 这里首先要对 input 进行初步处理
        input.value = '';
        if (value.charAt(0) == ':') {
            this.optionHandle(value); // 实现简单的指令
        } else {
            try {
                var res = window.eval(value); // 执行代码
                this.output(res);
            } catch (e) {
                console.log(e);
            }
        }
    };

// 核心代码块2
// 输出控制台内容到页面
JSUILogger.prototype.output = function (value, level, className) {

        if (!level) {
            level = levelColor.default;
        }

        var li = document.createElement('li');
        li.innerHTML = '<span style="color:' + level + '">' + value + '</span>';
        li.style.borderBottom = '1px solid #ccc';
        li.style.fontSize = '14px';
        li.style.height = 'auto';
        li.style.minHeight = '25px';
        li.style.lineHeight = '25px';
        li.style.padding = '0px';
        li.style.paddingLeft = '10px';
        li.style.margin = '0';
        li.style.boxSizing = 'border-box';
        li.className = className ? className : '';

        output.appendChild(li);

        li.scrollIntoView();
    };

// 核心代码块3
// 覆盖原生的 console.log等
(function () {

    console.oldLog = console.log;

    console.log = function () {
        global.JSUILogger.output([].join.call(arguments, ''), levelColor.log, 'log');
        this.oldLog.apply(this, arguments);
    };

    console.debug = function () {
        global.JSUILogger.output([].join.call(arguments, ''), levelColor.debug, 'debug');
        this.oldLog.apply(this, arguments);
    };

    console.error = function () {
        global.JSUILogger.output([].join.call(arguments, ''), levelColor.error, 'error');
        this.oldLog.apply(this, arguments);
    };

    console.info = function () {
        global.JSUILogger.output([].join.call(arguments, ''), levelColor.info, 'info');
        this.oldLog.apply(this, arguments);
    };

    console.debug = function () {
        global.JSUILogger.output([].join.call(arguments, ''), levelColor.debug, 'debug');
        this.oldLog.apply(this, arguments);
    };

    // 这是个特殊的方法,只在welcome 的时候使用,给不一样的类名,防止后续被清空
    console.init = function () {
        global.JSUILogger.output([].join.call(arguments, ''), levelColor.init, 'init');
        this.oldLog.apply(this, arguments);
    };

})();

```

这几个模块，就构成了一个完整的控制台方案：输入-->执行-->输出。

而代码的执行，则主要是基于eval。

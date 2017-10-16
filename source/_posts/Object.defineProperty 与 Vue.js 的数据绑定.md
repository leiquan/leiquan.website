---
title: Object.defineProperty 与 Vue.js 的数据绑定
date: 2017-10-16 10:25:04
category: 前端
tags:
  - VUE
  - JavaScript
---

Vue.js 是如何实现数据的双向绑定的？这是面试中经常问到的一个问题。

![Vue.js 的官网示意图](Object.defineProperty 与 Vue.js 的数据绑定/1.png)

<!--more-->

官网文档是有[详细解释](https://cn.vuejs.org/v2/guide/reactivity.html)的，但是还是有些不够，我也明白的不够深，来捋一下吧。

首先，是用到了 ES5 的[defineProperty](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/defineProperty)这一特性的，看一下其作用和参数。

```JavaScript
/**
* @param  obj The object on which to define the property.
* @param prop The name of the property to be defined or modified.
* @param descriptor The descriptor for the property being defined or modified.
* @return  The object that was passed to the function.
*/
Object.defineProperty(obj, prop, descriptor)
```

前两个参数就比较简单了，第三个则比较复杂一些，有 value 代表属性的值，proto代表继承属性的性质，这里面还有其他的选项：比如configurable,enumerable,writable等默认是false的。

```JavaScript
// MDN 例子和注释改了改
// 现在大家都喜欢吸猫？我清楚的记得 shadowsocks 开源管理项目 ss-panel 的作者把主要的变量以🐱命名...
// using __proto__
var cat = {};
var descriptor = Object.create(null); // no inherited properties
// not enumerable, not configurable, not writable as defaults
descriptor.value = 'Xu Jiufeng'; // 我朋友的一只猫叫做徐九凤，是个姑娘
Object.defineProperty(cat, 'name', descriptor);
```
在控制台感受一下，因为configurable默认为 False，所以 name 的值是无法改变的，改为 Hello Kitty 再输出 cat，还是徐九凤，要想能够被修改，所以就得设置为 True。

从 MDN 文档来看，descriptors（描述符）分成两种，一种是 data descriptors, 另外一种是 accessor descriptors。两种的 descriptors 有两个必选项, configurable和enumerable。

我们主要看 accessor descriptor 的 set 和 get。

get 定义了一个函数，作为属性的getter，如果没有getter就为undefined，默认为undefined；set 跟 get 差不多，用来取值，需要注意的是：可能会从原型链上面继承相应的属性，如果想避免这种情况，可以写get，所以可以设置 proto : null。

一个 HTML 来展示用 getter 和 setter 来进行数据绑定：

```html
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>徐九凤，你到底叫什么</title>
</head>

<body>

  <div>

    <p>你好，我是一只猫，叫做
      <input type="text" id='name'></span>
    </p>

  </div>

</body>

<script>

var cat = {};

Object.defineProperty(cat, "name", {
    get: function(){
        return document.getElementById('name').value;
    },
    set: function(name){
        document.getElementById('name').value = name;
    }
});

cat.name = '徐九凤';

setTimeout( function () {
  cat.name = 'Hello Kitty';
}, 5000);

</script>

</html>
```

5秒之后，我们的徐九凤就改名叫做 Hello Kitty 了。

因而，从数据到试图的实现，就完成了，所以我们在 Vue 中只需要设置数据，HTML 视图就会自动帮我们更新。

那从视图到数据呢？那个就更简单了，因为能从视图上改变数据的操作就那么些，无非是输入框手动输入...

当然了，Vue 的实现会比这个复杂一些，如题图，中间还多了层 Watcher，但是基本原理就是这样的，这就是为什么 Vue 不支持IE8以及更低浏览器的原因，因为它们无法实现Object.defineProperty。

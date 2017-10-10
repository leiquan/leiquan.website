---
title: LeetCode算法题-PlusOne
date: 2017-10-10 18:20:04
category: 数据结构和算法
tags:
  - LeetCode
  - 算法
---

##### LeetCode 题目：

Given a non-negative integer represented as a non-empty array of digits, plus one to the integer.

You may assume the integer do not contain any leading zero, except the number 0 itself.

The digits are stored such that the most significant digit is at the head of the list.

<!--more-->

##### 题目大意：
给定数以数组的形式存储，然后计算该数加1的值。

##### 代码和注释：

```JavaScript
/**

 * @param {number[]} digits
 * @return {number[]}
 */
var plusOne = function(digits) {

  // 从右往左
  for(var i=digits.length - 1; i >= 0; i--) {

    // 如果某一位，比如第一位，等于9，这一位9+1等于0
    if(digits[i]==9) {
       digits[i]=0;
    } else {

      // 第一位不等于9，加一直接返回，任何一位不等于9都加一返回
       ++digits[i];
       return digits;

     }

   }

  // 注意这两行的作用，这么处理的：
  // 只要执行到了这里，则意味着所有的位都是9，否则一定在前面就结束了如：789和999测试
  // 这种情况就要整体进位
  console.log('是否执行到这里');
  digits[0] = 1;
  digits.push(0);

  return digits;

};

// 测试代码
var a =[9,9,9];
console.log(plusOne(a));

```

##### 思路与注意：
主要是次数限定，超过两次无效，则不用管（不用删除），有效则操作。

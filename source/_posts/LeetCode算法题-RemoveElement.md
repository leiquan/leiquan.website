---
title: LeetCode算法题-RemoveElement
date: 2017-10-10 18:17:04
category: 数据结构与算法
tags:
  - LeetCode
  - 算法
---

##### LeetCode 题目：

 Given an array and a value, remove all instances of that value in place and return the new length.
 Do not allocate extra space for another array, you must do this in place with constant memory.
 The order of elements can be changed. It doesn't matter what you leave beyond the new length.

 Example:
 Given input array nums = [3,2,2,3], val = 3

 Your function should return length = 2, with the first two elements of nums being 2.

##### LeetCode URL：
https://leetcode.com/problems/remove-element

<!--more-->

##### 题目大意：
给定一个数组，去掉里面的重复元素，返回新数组长度，并且要求不允许新建数组，只能在原始数组操作。

##### 代码和注释：

```JavaScript
/**

 * @param {number[]} nums 需要处理的数组
 * @param {number} val 需要去掉的值
 * @return {number} 新数组长度
 */
var removeElement = function(nums, val) {

  var j = 0;

  for (var i = 0; i < nums.length; i++) {

    // 两者相等就跳过
    if (nums[i] == val) {
      continue;
    }
    // 否则，用当前的数组元素去新建数组，因为 j是从0开始的，所以整个新数组都将被不重复的元素逐一代替
    nums[j] = nums[i]; // i 一定大于 j
    j++; //让新数组下标增长

  }

  return j; // 因为 j++了，所以，j 的大小就是新数组的大小

};

// 测试代码
var arr =[1,2,3,4,5,6,7,8,2];
console.log(removeElement(arr, 2));

```

##### 思路与注意：
在原数组的基础上，从 index 等于0开始，逐一用当前元素替换

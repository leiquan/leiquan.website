---
title: LeetCode算法题-RemoveDuplicates
date: 2017-10-10 18:18:04
category: 数据结构和算法
tags:
  - LeetCode
  - 算法
---

##### LeetCode 题目：

Given a sorted array, remove the duplicates in place such that each element appear only once and return the new length.
Do not allocate extra space for another array, you must do this in place with constant memory.

For example,
Given input array nums = [1,1,2],

Your function should return length = 2, with the first two elements of nums being 1 and 2 respectively. It doesn't matter what you leave beyond the new length.

##### LeetCode URL：
https://leetcode.com/problems/remove-duplicates-from-sorted-array/description/

<!--more-->

##### 题目大意：
给定一个排序过的数组，去掉里面的重复元素，返回新数组长度，并且要求不允许新建数组，只能在原始数组操作。

##### 代码和注释：

```JavaScript
/**

* @param {number[]} nums 需要处理的数组
* @return {number} 新数组长度
*/
var removeDuplicates = function(nums) {

 var j = 0;

 for (var i = 1; i < nums.length; i++) {

   // 因为是已经排序，这里要比较相邻两个元素,是否相等
   if (nums[j] != nums[i]) {
     nums[++j] = nums[i]; // 第一次循环，nums[j]为1，nums[i]为2，第一个一定会有，不用管，只管++j；如果相等，则新数组不操作，不等则将原值复制过来
   }

 }

 return j+1;

};


// 测试代码
var arr =[1,2,2,3,3,3,4];
console.log(removeDuplicates(arr));

```

##### 思路与注意：
在原数组的基础上，从 index 等于1开始，等于则忽略，不等则用新数组覆盖，注意，由于是覆盖，那么新数组一定短于长数组，所以新数组后面部分无用，如果求数组则需要去掉。

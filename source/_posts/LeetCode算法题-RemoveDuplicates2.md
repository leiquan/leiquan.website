---
title: LeetCode算法题-RemoveDuplicates2
date: 2017-10-10 18:19:04
category: 数据结构和算法
tags:
  - LeetCode
  - 算法
---

##### LeetCode 题目：

Follow up for "Remove Duplicates":
What if duplicates are allowed at most twice?

For example,
Given sorted array nums = [1,1,1,2,2,3],

Your function should return length = 5, with the first five elements of nums being 1, 1, 2, 2 and 3.
It doesn't matter what you leave beyond the new length.

<!--more-->

##### 题目大意：
给定一个排序过的数组，去掉里面的重复元素，注意，他们最多可以重复两次，只除去超过两次的部分，返回新数组长度，并且要求不允许新建数组，只能在原始数组操作。

##### 代码和注释：

```JavaScript
/**

 * @param {number[]} nums 需要处理的数组
 * @return {number} 新数组长度
 */
var removeDuplicates2 = function(nums) {

  var j = 0;
  var count = 0; // 重复计数器

  for (var i = 1; i < nums.length; i++) {

    // 因为是已经排序，这里要比较相邻两个元素,是否相等，如果相等，可以等于几次
    if (nums[j] == nums[i]) {

      count++;

      // 两次之内合法，超过两次不管
      if (count < 2 ) {
        nums[++j] = nums[i];
      }

    }
    // 不等也合法
    else {
      nums[++j] = nums[i];
      count = 0; //重置计数器
    }

  }

  return j+1;

};

// 测试代码
var a =[1,1,1,1,1,2,2,2,2,3,3,3,3,4,4,5];
console.log(removeDuplicates2(a));

```

##### 思路与注意：
主要是次数限定，超过两次无效，则不用管（不用删除），有效则操作。

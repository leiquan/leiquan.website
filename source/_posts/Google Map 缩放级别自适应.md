---
title: Google Map 缩放级别自适应
date: 2018-04-11 17:26:00
category: 前端
tags:
  - Google Map
---

因为业务需要，需要实现一个地理围栏的自适应显示，也就是要根据围栏的数量和大小，把所有的围栏以合适的缩放级别全部展示在地图里。

以下为核心代码，主要用到了Google Map 的fitBounds 方法。

<!--more-->

```javascript
getSWNE () {

        let minLat = 0;
        let minLng = 0;
        let maxLat = 0;
        let maxLng = 0;

        for(let i = 0; i < this.state.allCoords.length; i++) {
            console.log(this.state.allCoords[i]);
            if (i == 0) {
                minLat = this.state.allCoords[i].lat;
                minLng = this.state.allCoords[i].lng;
                maxLat = this.state.allCoords[i].lat;
                maxLng = this.state.allCoords[i].lng;
            } else {
                if (minLat > this.state.allCoords[i].lat) {
                    minLat = this.state.allCoords[i].lat
                }
                if (minLng > this.state.allCoords[i].lng) {
                    minLng = this.state.allCoords[i].lng
                }
                if (maxLat < this.state.allCoords[i].lat) {
                    maxLat = this.state.allCoords[i].lat
                }
                if (maxLng < this.state.allCoords[i].lng) {
                    maxLng = this.state.allCoords[i].lng
                }
            }
        }
        return {
            minLat: minLat,
            minLng: minLng,
            maxLat: maxLat,
            maxLng: maxLng
        }
}

if (this.getSWNE().minLat != 0 && this.getSWNE().minLng != 0 && this.getSWNE().maxLat !=0 && this.getSWNE().maxLng !=0) {
  console.log('进入到调整缩放', this.getSWNE());
  var p1 = new google.maps.LatLng(this.getSWNE().minLat, this.getSWNE().minLng); // min，min,左下角
  var p2 = new google.maps.LatLng(this.getSWNE().maxLat, this.getSWNE().maxLng); // max, max，右上角
  var bounds = new google.maps.LatLngBounds(p1, p2); // (LatLng southwest, LatLng northeast) 西南，东北
  map.fitBounds(bounds);
}
```

继续加班。



---
title: 初识mobx
date: 2018-01-11 22:43:04
category: 前端
tags:
  - mbox
  - React
---

其实也不算初始了，大半年前在百度的时候就有小组内小伙伴分享过了，只是这种东西一直没项目中用，就懒得去理解。今天看了下，跟VueX的思路差不多，而且也一样简单。

记录一下，代码不复杂，就直接贴代码吧。

<!--more-->

package.json

```javascript
{
    "name": "mbox-first-glance",
    "version": "1.0.0",
    "scripts": {
        "start": "webpack-dev-server --hot --open"
    },

    "devDependencies": {
        "babel-core": "^6.9.1",
        "babel-loader": "^7.1.2",
        "babel-plugin-transform-decorators-legacy": "^1.3.4",
        "babel-preset-es2015": "^6.9.0",
        "babel-preset-react": "^6.5.0",
        "babel-preset-stage-1": "^6.5.0",
        "webpack": "^3.5.5",
        "webpack-dev-server": "^2.7.1"
    },
    "dependencies": {
        "mobx": "^3.0.0",
        "mobx-react": "^4.1.0",
        "react": "^15.1.0",
        "react-dom": "^15.1.0"
    }
}
```

webpack.config.js

```javascript
var path = require('path');
var webpack = require('webpack');

module.exports = {
    devtool: 'eval',
    entry: [
        './src/index'
    ],
    output: {
        path: path.join(__dirname, 'dist'),
        filename: 'bundle.js',
        publicPath: '/static/'
    },
    plugins: [
        new webpack.HotModuleReplacementPlugin()
    ],
    resolve: {
        extensions: ['.js', '.jsx']
    },
    module: {
        rules: [{
            test: /\.jsx?$/,
            loader: 'babel-loader',
            include: path.join(__dirname, 'src'),
            query: {
                presets: [
                    "react",
                    "es2015",
                    "stage-1"
                ],
                plugins: ["transform-decorators-legacy"]
            }
        }]
    }
};
```

index.js

```javascript
import React from 'react';
import ReactDOM  from 'react-dom';
import {observable, action, computed} from 'mobx';
import {observer} from 'mobx-react';

class Store {

  // 被观察者
  @observable 
  todos = [{
    title: "完成 Mobx 翻译",
    done: true,
  },
  {
    title: "未完成 Mobx 翻译",
    done: false,
  }
];

  // 行为
  @action 
  changeTodoTitle({index,title}){
    this.todos[index].title = title
  }

  // 衍生值
  @computed 
  get finishedTodos () {
    return  this.todos.filter((todo) => todo.done)
  }

}

// 观察者
@observer
class TodoBox extends React.Component  {

  constructor(props){
    super(props);
    setTimeout(function(){
      // 通过 action 来操作store，避免直接操作 store
      props.store.changeTodoTitle({index:0,title:"修改后的todo标题"});
    }, 3000);
  }

  render() {
    return (
      <ul style={{width: '40%', float:'left'}}>
        <div style={{backgroundColor:'red'}}>
          {this.props.store.todos.map((todo, i) => <li key={i}>{todo.title}</li>)}
        </div>
        <div style={{backgroundColor:'blue'}}>
          {this.props.store.finishedTodos.map((todo, i) => <li key={i}>{todo.title}</li>)}
        </div>
      </ul>
      
    )
  }
}

@observer
class TodoBox2 extends React.Component  {

  constructor(props){
    super(props);
    setTimeout(function(){
      // 通过 action 来操作store，避免直接操作 store
      props.store.changeTodoTitle({index:0,title:"修改后的todo标题"});
    }, 3000);
  }

  render() {
    return (
      <ul style={{width: '40%', float:'left'}}>
        <div style={{backgroundColor:'red'}}>
          {this.props.store.todos.map((todo, i) => <li key={i}>{todo.title}</li>)}
        </div>
        <div style={{backgroundColor:'blue'}}>
          {this.props.store.finishedTodos.map((todo, i) => <li key={i}>{todo.title}</li>)}
        </div>
      </ul>
      
    )
  }
}


const store = new Store();

ReactDOM.render(
  <div>
    <TodoBox store={store} />
    <TodoBox2 store={store} />
  </div>,
  document.getElementById('root')
);
```

##### 小结：

store 是一个包含了数据本身和数据操作方法的集合仓库，跟数据相关的值、操作都在这里，组件中只涉及到 action，通过 action 来操作值，以此来分离数据和组件。这些数据和数据操作方法，被引用的组件所共享，因此，一个数据发生了改变，多个组件都可以得到同步改变。

概念一：observable， '被观察者'，也就是数据本身，被'观察者'所观察，只要'被观察者'发生了改变，那么观察者会自动更新；

概念二：observer，'观察者'，也就是组件，引用了store做为数据源，而store里面有'被观察者'，因此二者得以联系起来，因此直接操作'被观察者'即可，'被观察者'变动后，所有的'观察者’都闻风而动；

概念三：action, 行为，跟 VueX一样，操作 Store 的行为，只应该在 action 里面操作 Store，以避免混乱，因为所有的操作都有对应action，因此可以保持数据可跟踪，而不会在各个地方的变量里面各种赋值导致不知道哪里被赋值了的窘境；

概念四：computed，衍生值，也就是计算值，跟VueX一样，加工过后的值，因为纯粹的数据并不能满足需求，而在组件内做复杂操作会有无法触发render,因此需要再这里注册。




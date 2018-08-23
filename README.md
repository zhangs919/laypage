[![Latest Stable Version](https://poser.pugx.org/andy/laypage/v/stable)](https://packagist.org/packages/andy/laypage)
[![Total Downloads](https://poser.pugx.org/andy/laypage/downloads)](https://packagist.org/packages/andy/laypage)
[![Latest Unstable Version](https://poser.pugx.org/andy/laypage/v/unstable)](https://packagist.org/packages/andy/laypage)
[![License](https://poser.pugx.org/andy/laypage/license)](https://packagist.org/packages/andy/laypage)


#### 项目介绍
layui 分页封装 基于PHP原生

#### 用法
~~~php
    $count = 100; 
    $extraParams = [
        'param1' => 'value1',
        'param2' => 'value2'
        // ...
    ];
    $page = lay_page($count, '', ['cid' => 1]); // layui 分页渲染
    
    $list = []; // 数据列表
~~~

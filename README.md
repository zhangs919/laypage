# layui.page

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

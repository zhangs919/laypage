<?php

namespace LayPage;

class LayPage
{
    public function pagination()
    {
        $count = 100;
        $extraParams = [
            'param1' => 'value1',
            'param2' => 'value2'
            // ...
        ];
        $pageHtml = lay_page($count, '', ['cid' => 1]); // layui 分页渲染

        $list = []; // 数据列表
    }
}
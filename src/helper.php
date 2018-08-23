<?php

// +----------------------------------------------------------------------
// | Apprh
// +----------------------------------------------------------------------
// | Copyright (c) 2017-2017 http://www.apprh.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 雲溪荏苒 <290648237@qq.com>
// +----------------------------------------------------------------------

/**
 * 将字符串参数变为数组
 * @param $query
 * @return array array (size=10)
 * 'm' => string 'content' (length=7)
 * 'c' => string 'index' (length=5)
 * 'a' => string 'lists' (length=5)
 * 'catid' => string '6' (length=1)
 * 'area' => string '0' (length=1)
 * 'author' => string '0' (length=1)
 * 'h' => string '0' (length=1)
 * 'region' => string '0' (length=1)
 * 's' => string '1' (length=1)
 * 'page' => string '1' (length=1)
 */
function convert_url_query($query)
{
    $queryParts = explode('&', $query);
    $params = array();
    foreach ($queryParts as $param) {
        $item = explode('=', $param);
        $params[$item[0]] = $item[1];
    }
    return $params;
}

/**
 * 将参数变为字符串
 * @param $array_query
 * @return string string 'm=content&c=index&a=lists&catid=6&area=0&author=0&h=0®ion=0&s=1&page=1' (length=73)
 */
function get_url_query($array_query)
{
    $tmp = array();
    foreach($array_query as $k=>$param)
    {
        $tmp[] = $k.'='.$param;
    }
    $params = implode('&',$tmp);
    return $params;
}

/**
 * 设置url中的参数
 * @param $url
 * @param $params
 * @return string
 */
function set_url($url, $params){
    $arr = parse_url($url);
    $arr_query = isset($arr['query'])?convert_url_query($arr['query']):[];
    foreach($params as $key=>$value){
        if($value){
            $arr_query[$key] = $value;
        }else{
            unset($arr_query[$key]);
        }
    }

    return $arr['scheme'].'://'.$arr['host'].$arr['path'].(get_url_query($arr_query)?'?':'').get_url_query($arr_query);
}

/**
 * 获取layui 分页url
 * @param string $path 传入分页path 如： "cms/Article/list"
 * @param array $extraParams 传入分页额外参数 如： "['cid' => 123, 'aid' => 234]"
 * @return string
 *
 * @author 雲溪荏苒 <290648237@qq.com>
 * @date 2017-09-29
 */
function get_layui_page_url($path = '', $extraParams = [])
{
    $urlArr = parse_url('http://' . $_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"]);

    if($path == ''){
        // TODO 如果没传入url path路径 则自动获取url中的path路径
        $path = $urlArr['path'];
    }

    $urlString = set_url('http://' . $_SERVER['HTTP_HOST'].$path, $extraParams);
    $urlArr = parse_url($urlString);

    if($path == ''){
        // TODO 如果没传入url path路径 则自动获取url中的path路径
        $path = $urlArr['path'];
    }

    $arrString = ''; // 初始化
    if(isset($urlArr['query'])){
        // 有参数
        $arr_query = convert_url_query($urlArr['query']);
        unset($arr_query['currpage']);
        $arrString = get_url_query($arr_query);
    }

    if($arrString != ''){
        $arrString = $path.'?'.$arrString.'&';
    }else{
        $arrString = $path.'?';
    }
    return $arrString;
}

/**
 * layui 分页封装 调用此函数即可
 * @param $count
 * @param string $path 传入分页path 如： "cms/Article/list"
 * @param array $extraParams 传入分页额外参数 如： "['cid' => 123, 'aid' => 234]"
 * @return string
 *  用法：  $page = lay_page($count, 'cms/Article/list', ['cid' => 1]);
 *          $this->assign('page', $page);
 * @author 雲溪荏苒 <290648237@qq.com>
 * @date 2017-09-29
 */
function lay_page($count, $path = '', $extraParams = [])
{
    // $curPage = request()->param('curpage', 1); // 写法一 thinkphp5
    $curPage = !empty($_GET['curpage']) ? $_GET['curpage'] : 1; // 写法二 php原生写法

    $urlString = get_layui_page_url($path, $extraParams);

    $page = '<div id="page"></div>';
    $page .= '<script language="JavaScript">
    function lay_page (total, cur_page, url_string) {
        layui.use([\'laypage\', \'layer\'], function() {
            var laypage = layui.laypage
                , layer = layui.layer;
    
            laypage.render({
                elem: \'page\'
                ,count: total
                ,curr: cur_page
                ,layout: [\'count\', \'prev\', \'page\', \'next\', \'limit\', \'skip\']
                ,jump: function(obj, first){
                    console.log(url_string)
                    console.log(obj.curr);
    
                    if(!first){
                        window.location.href = url_string + \'curpage=\' + obj.curr;
                    }
                }
            });
        });
    }
</script>';
    $page .= '<script>';
    $page .= 'lay_page(\''.$count.'\', \''.$curPage.'\', \''.$urlString.'\')';
    $page .= '</script>';

    return $page;
}

<?php
require "vendor\autoload.php";
use QL\QueryList;

$data = QueryList::get('https://www.baidu.com/s?wd=QueryList')
// 设置采集规则
    ->rules([
        'title' => array('h3', 'text'),
        'link'  => array('h3>a', 'href'),
    ])
    ->queryData();

print_r($data);

$ql     = QueryList::get('https://www.baidu.com/s?wd=QueryList');
$titles = $ql->find('h3>a')->texts(); //获取搜索结果标题列表
$links  = $ql->find('h3>a')->attrs('href'); //获取搜索结果链接列表
print_r($titles);
print_r($links);

//采集某页面所有的图片
$data = QueryList::get('http://cms.querylist.cc/bizhi/453.html')->find('img')->attrs('src');
//打印结果
print_r($data->all());

<?php
require "../init.php";
use QL\QueryList;

$ql = QueryList::get('https://www.baidu.com/s?wd=QueryList');
$titles = $ql->find('h3>a')->texts(); //获取搜索结果标题列表
$links = $ql->find('h3>a')->attrs('href'); //获取搜索结果链接列表
print_r($titles);
print_r($links);
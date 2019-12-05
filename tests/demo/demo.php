<?php
require "../init.php";
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



 //采集开发者头条
$ql = QueryList::getInstance();
//注册一个myHttp方法到QueryList对象
$ql->bind('myHttp',function ($url){
    $html = file_get_contents($url);
    $this->setHtml($html);
    return $this;
});
//然后就可以通过注册的名字来调用
$data = $ql->myHttp('https://toutiao.io')->find('h3 a')->texts();
print_r($data->all());
//或者这样用
$data = $ql->rules([
    'title' => ['h3 a','text'],
    'link' => ['h3 a','href']
])->myHttp('https://toutiao.io')->query()->getData();
print_r($data->all());


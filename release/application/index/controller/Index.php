<?php
namespace app\index\controller;
use QL\QueryList;

class Index
{
    public function index()
    {
       //采集某页面所有的图片
       $data = QueryList::get('http://cms.querylist.cc/bizhi/453.html')->find('img')->attrs('src');
       //打印结果
       dump($data->all());
    }
}

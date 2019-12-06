<?php
require "../init.php";
use GuzzleHttp\Client;
use QL\QueryList;

/*初始化*/
// $ql = QueryList::getInstance();

/*百度搜索 1、百度安全验证？；*/
$url    = 'https://www.baidu.com/s';
$params = ['wd' => 'QueryList'];

// QueryList
$data = QueryList::get($url . '?' . http_build_query($params))
    ->rules([
        'title' => array('h3', 'text'),
        'link'  => array('h3>a', 'href'),
    ]) //采集规则
    ->queryData();
print_r($data);

// 使用Client 1、https需要ssl支持
$client = new Client();
$res    = $client->request('GET', $url, $params);
$html   = (string) $res->getBody();
print_r($html);

$data = QueryList::html($html)->find('h3')->texts();

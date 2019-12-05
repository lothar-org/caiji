<?php
require "vendor\autoload.php";

use QL\Ext\PhantomJs;
use QL\QueryList;

/*京东拍卖数据采集*/
$url    = 'https://auction.jd.com/paimai_list.html';
$url    = 'https://auction.jd.com/paimai_list.html?t=1&limit=40&page=2';
$config = include 'data/config.php';

/*DOM 采集不到数据？？？*/
// $data = QueryList::get($url)->find('li.item .p-name')->texts();
// print_r($data->all());

// $data = QueryList::get($url)->find('img')->attrs('src');
// print_r($data->all());

/*JS*/
$ql = QueryList::getInstance();
$ql->use(PhantomJs::class, $config['jspath'], 'browser'); //注册一个browser方法到QueryList对象
// $data = $ql->browser($url)->find('#plist li a.p-img img')->texts();
// print_r($data->all());

// 复杂的
$obj = $ql->browser(function (\JonnyW\PhantomJs\Http\RequestInterface $r) use ($url) {
    $r->setMethod('GET');
    $r->setUrl($url);
    $r->setTimeout(10000); // 10 seconds
    $r->setDelay(5); // 3 seconds
    return $r;
});

// $data = $obj->getHtml();
// print_r($data);

// $data = $obj->find('img')->attrs('src');
// $data = $obj->find('img')->attrs('data-lazy-img');
$data = $obj->rules([
    'title' => ['li.item .p-name', 'text'],
    'link'  => ['li.item .p-name', 'href'],
    'img'   => ['li.item .p-img img', 'data-lazy-img'],
    'price' => ['li.item .p-price', 'text'],
])
->query()->getData();
// ->queryData();

print_r($data->all());
// print_r($data);

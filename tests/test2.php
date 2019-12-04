<?php

require "vendor\autoload.php";

use QL\Ext\PhantomJs;
use QL\QueryList;

$url = 'https://auction.jd.com/paimai_list.html';

// $data = QueryList::get($url)->find('img')->attrs('data-lazy-img');
// print_r($data->all());


$ql = QueryList::getInstance();
$jspath = 'D:/cmd/phantomjs/bin/phantomjs.exe';
// $ql->use(PhantomJs::class, $jspath);
$ql->use(PhantomJs::class, $jspath, 'browser');

// $data = QueryList::get($url)->find('img')->attrs('src');
// print_r($data->all());

// $data = $ql->browser($url)->find('#plist li a.p-img img')->texts();
// print_r($data->all());


/*JS*/
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
// print_r($data->all());









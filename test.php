<?php
// Usage

// Installation Plugin
use QL\QueryList;
use QL\Ext\PhantomJs;

$ql = QueryList::getInstance();
// Set PhantomJS bin path
$ql->use(PhantomJs::class,'/usr/local/bin/phantomjs');
//or Custom function name
$ql->use(PhantomJs::class,'/usr/local/bin/phantomjs','browser');



// Example-1
$html = $ql->browser('https://m.toutiao.com')->getHtml();
print_r($html);

$data = $ql->browser('https://m.toutiao.com')->find('p')->texts();
print_r($data->all());

// Command option see: http://phantomjs.org/api/command-line.html
$ql->browser('https://m.toutiao.com',true,[
    '--proxy' => '192.168.1.42:8080',
    '--proxy-type' => 'http'
]);


// Example-2
// $data = $ql->browser(function (\JonnyW\PhantomJs\Http\RequestInterface $r){
//     $r->setMethod('GET');
//     $r->setUrl('https://m.toutiao.com');
//     $r->setTimeout(10000); // 10 seconds
//     $r->setDelay(3); // 3 seconds
//     return $r;
// })->find('p')->texts();

// print_r($data->all());



// Example-3
// $data = $ql->browser(function (\JonnyW\PhantomJs\Http\RequestInterface $r){
//     $r->setMethod('GET');
//     $r->setUrl('https://m.toutiao.com');
//     $r->setTimeout(10000); // 10 seconds
//     $r->setDelay(3); // 3 seconds
//     return $r;
// },true,[
//     '--cookies-file' => '/path/to/cookies.txt'
// ])->rules([
//     'title' => ['p','text'],
//     'link' => ['a','href']
// ])->query()->getData();

// print_r($data->all());



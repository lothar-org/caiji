<?php

require "vendor\autoload.php";
use JonnyW\PhantomJs\Client;
// require_once 'vendor_phantomjs/jonnyw/php-phantomjs/src/JonnyW/PhantomJs/Client.php';

$client = Client::getInstance();
$client->getEngine()->setPath('D:/cmd/phantomjs/bin/phantomjs.exe');
//上面一行要填写自己的phantomjs路径

/**
 * @see JonnyW\PhantomJs\Http\PdfRequest
 **/
$delay   = 7;
$request = $client->getMessageFactory()->createPdfRequest('https://www.baidu.com/', 'GET', 5000); //参数里面的数字5000是网页加载的超时时间，放在网络问题一直加载，可以不填写，默认5s。
$request->setOutputFile('E:/document.pdf');
$request->setFormat('A4');
$request->setOrientation('landscape');
$request->setMargin('1cm');
$request->setDelay($delay); //设置delay是因为有一些特效会在页面加载完成后加载，没有等待就会漏掉

/**
 * @see JonnyW\PhantomJs\Http\Response
 **/
$response = $client->getMessageFactory()->createResponse();

// Send the request
$client->send($request, $response);

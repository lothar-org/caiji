<?php
require "../init.php";
use JonnyW\PhantomJs\Client;
 
$client = Client::getInstance();
 
$client->getEngine()->setPath($config['jspath']); //设置phantomjs位置
$client->getEngine()->addOption('--load-images=false');
$client->getEngine()->addOption('--ignore-ssl-errors=true');
 
$url = 'https://www.baidu.com';
$request = $client->getMessageFactory()->createRequest($url, 'GET');
 
$timeout = 10000; //设置超时
$request->setTimeout($timeout);
 
$request->addSetting('userAgent', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36');//设置ua
 
$response = $client->getMessageFactory()->createResponse();
$client->send($request, $response);
 
echo $response->getContent();
?>
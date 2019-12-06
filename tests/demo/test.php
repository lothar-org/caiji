<?php
require "../init.php";
// Usage
use QL\QueryList;
use QL\Ext\PhantomJs;

/*初始化*/
$ql = QueryList::getInstance();

$jspath = $config['jspath'];
// $ql->use(PhantomJs::class, $jspath);//Set PhantomJS bin path
$ql->use(PhantomJs::class, $jspath, 'browser');//or Custom function name

// loadHTML();
// libxml_use_internal_errors(true);

/*示例*/
// Example-1
// 获取动态渲染的HTML:
// $html = $ql->browser('https://m.toutiao.com')->getHtml();
// print_r($html);

// 获取所有p标签文本内容:
// $data = $ql->browser('https://m.toutiao.com')->find('p')->texts();
// print_r($data->all());

// 使用http代理:
// Command option see: http://phantomjs.org/api/command-line.html
// $ql->browser('https://m.toutiao.com',true,[
//     '--proxy' => '192.168.1.42:8080',
//     '--proxy-type' => 'http'
// ]);

// Example-2
// 自定义一个复杂的请求：
// $data = $ql->browser(function (\JonnyW\PhantomJs\Http\RequestInterface $r){
//     $r->setMethod('GET');
//     $r->setUrl('https://m.toutiao.com');
//     $r->setTimeout(10000); // 10 seconds
//     $r->setDelay(3); // 3 seconds
//     return $r;
// })->find('p')->texts();

// print_r($data->all());

// Example-3
// 开启debug模式，并从本地加载cookie文件：
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

///////
//功能性 //
///////

/**
 * JS动态加载
 * single-mode-rbox
 */
// $data = $ql->browser(function (\JonnyW\PhantomJs\Http\RequestInterface $r){
//     $r->setMethod('GET');
//     $r->setUrl('https://m.toutiao.com');
//     $r->setTimeout(10000); // 10 seconds
//     $r->setDelay(5); // 3 seconds
//     return $r;
// })->find('.title-box>a')->texts();
// print_r($data->all());

// 懒加载采集 连续动作：滚屏


/**
 * 模拟登录
 */
// $ql->post('http://httpbin.org/post', [
//     'param1'  => 'testvalue',
//     'params2' => 'somevalue',
// ], [
//     'proxy'   => 'http://222.141.11.17:8118',
//     'timeout' => 30,
//     'headers' => [
//         'Referer'    => 'https://querylist.cc/',
//         'User-Agent' => 'testing/1.0',
//         'Accept'     => 'application/json',
//         'X-Foo'      => ['Bar', 'Baz'],
//         'Cookie'     => 'abc=111;xxx=222',
//     ],
// ]);
// echo $ql->getHtml();

// post和get连贯操作
// http插件默认已经开启了全局cookie，post操作和get操作是cookie共享的,意味着你可以先调用post方法登录，然后get方法就可以采集所有登录后的页面。
$ql = QueryList::post('http://xxxx.com/login', [
    'username' => 'admin',
    'password' => '123456',
])->get('http://xxx.com/admin');
$ql->get('http://xxx.com/admin/page');
//echo $ql->getHtml();

// 实战：模拟登陆GitHub
// 下面的这个例子，也是querylist官方网站给出的例子。先登陆github，然后再做个get请求。
// $ql = QueryList::getInstance();
//手动设置cookie
$jar = new \GuzzleHttp\Cookie\CookieJar();
//获取到登录表单
$form = $ql->get('https://github.com/login', [], [
    'cookies' => $jar,
])->find('form');
//填写GitHub用户名和密码
$form->find('input[name=login]')->val('your github username or email');
$form->find('input[name=password]')->val('your github password');
//序列化表单数据
$fromData = $form->serializeArray();
$postData = [];
foreach ($fromData as $item) {
    $postData[$item['name']] = $item['value'];
}
//提交登录表单
$actionUrl = 'https://github.com' . $form->attr('action');
$ql->post($actionUrl, $postData, [
    'cookies' => $jar,
]);
//判断登录是否成功
// echo $ql->getHtml();
$userName = $ql->find('.header-nav-current-user>.css-truncate-target')->text();
if ($userName) {
    echo '登录成功!欢迎你:' . $userName;
} else {
    echo '登录失败!';
}

/**
 * 多级递归采集
 */
// 可以在getData()方法中多次调用QueryList来实现递归多级采集。所以基本套路是这样的：
// $ql->getData(function($item){
//     $item['...'] = QueryList::html($item['...'])->...()->query()->getData();
//     return $item;
// });
//获取每个li里面的h3标签内容，和class为item的元素内容
$html = <<<STR
    <div id="demo">
        <ul>
            <li>
              <h3>xxx</h3>
              <div class="list">
                <div class="item">item1</div>
                <div class="item">item2</div>
              </div>
            </li>
             <li>
              <h3>xxx2</h3>
              <div class="list">
                <div class="item">item12</div>
                <div class="item">item22</div>
              </div>
            </li>
        </ul>
    </div>
STR;
$data = QueryList::html($html)->rules(array(
    'title' => array('h3', 'text'),
    'list'  => array('.list', 'html'),
))->range('#demo li')->query()->getData(function ($item) {
    $item['list'] = QueryList::html($item['list'])->rules(array(
        'item' => array('.item', 'text'),
    ))->query()->getData();
    return $item;
});
print_r($data);

/**
 * 批量采集
 */
$ql = QueryList::rules([
  //....
]);
foreach ($urls as $url) {
    $ql->get($url)->query()->getData();
    // 释放资源，销毁内存占用
    $ql->destruct();
}

<?php
require "../init.php";
use QL\QueryList;

/*初始化*/
$ql = QueryList::getInstance();

//手动设置cookie
$jar = new \GuzzleHttp\Cookie\CookieJar();
//获取到登录表单
$form = $ql->get('https://github.com/login', [], [
    'cookies' => $jar,
])->find('form');
//填写GitHub用户名和密码
$form->find('input[name=login]')->val('luosader');
$form->find('input[name=password]')->val('md5($oO0);');
//序列化表单数据
$fromData = $form->serializeArray();
$postData = [];
foreach ($fromData as $item) {
    $postData[$item['name']] = $item['value'];
}
//提交登录表单
$actionUrl = 'https://github.com' . $form->attr('action');
// $actionUrl = 'https://github.com/session';
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
<?php
require "../init.php";
use QL\QueryList;
// use QL\Ext\PhantomJs;

/*初始化*/
$ql = QueryList::getInstance();

/*公拍网*/
$url = 'http://s.gpai.net/sf/search.do';

// .list-item
$data = $ql->get($url)->rules([
    'title' => ['.main-col-list li .item-tit', 'text'],
    'link' => ['.main-col-list li .item-tit a', 'href'],
    'img' => ['.main-col-list li a>img', 'src'],
    '最新价' => ['.main-col-list li .gpai-infos>p:eq(1)>b', 'text'],
    '评估价'   => ['.main-col-list li .gpai-infos>p:eq(3)>b', 'text'],
])->query()->getData();
print_r($data->all());


// 详情页
$url = 'http://www.gpai.net/sf/item2.do?Web_Item_ID=26033';

// $data = $ql->get($url)->getHtml();
// print_r($data);

$data = $ql->get($url)->rules([
    '拍卖物' => ['.details-main .d-m-title', 'text'],
    '成交价' => ['.details-main .d-m-price b', 'text'],
    '起拍价'  => ['.details-main .d-m-tb #Price_Start', 'text'],
    '保证金'   => ['.details-main .d-m-tb table>tr:eq(2)>td:eq(1)', 'text'],
    '评估价'   => ['.details-main .d-m-tb table>tr:eq(3)>td:eq(0)', 'text'],
])->queryData();

// foreach ($data as $key => $value) {
//     # code...
// }

print_r($data);
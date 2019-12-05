<?php
require "../init.php";
use QL\QueryList;
// use QL\Ext\PhantomJs;

/*初始化*/
$ql = QueryList::getInstance();

/*阿里拍卖*/
$url = 'https://sf.taobao.com/item_list.htm';

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
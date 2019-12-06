<?php
require "../init.php";
use QL\QueryList;
// use QL\Ext\PhantomJs;

/*初始化*/
$ql = QueryList::getInstance();

/*公拍网*/

// 列表页
$url  = 'http://s.gpai.net/sf/search.do';
$data = $ql->get($url)
    ->rules([
        'title' => ['.item-tit>a', 'text'],
        'link'  => ['.item-tit>a', 'href'],
        'img'   => ['a>img', 'src'],
        '最新价'   => ['.gpai-infos>p:eq(1)>b', 'text'],
        '评估价'   => ['.gpai-infos>p:eq(2)>span:eq(1)', 'text'],
    ])
    ->range('.main-col-list>li') // 切片选择器
    ->query()->getData();
print_r($data->all());

$ql->destruct(); //释放资源，销毁内存占用

// 详情页
$url = 'http://www.gpai.net/sf/item2.do?Web_Item_ID=26033';
// $data = $ql->get($url)->getHtml();
// print_r($data);
$data = $ql->get($url)->rules([
    '拍卖物' => ['.details-main .d-m-title', 'text'],
    '成交价' => ['.details-main .d-m-price b', 'text'],
    '起拍价' => ['.details-main .d-m-tb #Price_Start', 'text'],
    '保证金' => ['.details-main .d-m-tb table>tr:eq(2)>td:eq(1)', 'text'],
    '评估价' => ['.details-main .d-m-tb table>tr:eq(3)>td:eq(0)', 'text'],
])->queryData();
foreach ($data as $key => $v) {
    $data[$key]['保证金'] = preg_replace('/[^\d\.]/i', '', $v['保证金']);
    $data[$key]['评估价'] = preg_replace('/[^\d\.]/i', '', $v['评估价']);
}
print_r($data);

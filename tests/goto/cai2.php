<?php
require "../init.php";
use QL\Ext\PhantomJs;
use QL\QueryList;

/*初始化*/
$ql = QueryList::getInstance();
// $ql->use(PhantomJs::class, $config['jspath'], 'browser');

/*阿里拍卖*/

// 列表页
$url = 'https://sf.taobao.com/item_list.htm';
// $data = $ql->get($url)->encoding('UTF-8','GB2312')->getHtml();
// print_r($data);

// 使用插件
// $html = $ql->browser('https://m.toutiao.com')->getHtml();
// print_r($html);

// $obj = $ql->browser(function (\JonnyW\PhantomJs\Http\RequestInterface $r) use ($url) {
//     $r->setMethod('GET');
//     $r->setUrl($url);
//     $r->setTimeout(10000); // 10 seconds
//     $r->setDelay(5); // 3 seconds
//     return $r;
// });
// $data = $obj->rules([
//     'title' => ['.header-section p.title', 'text'],
//     'link'  => ['.link-wrap', 'href'],
//     'img'   => ['.header-section>img', 'src'],
//     '当前价'   => ['.info-section .price-current>.value', 'text'],
//     '评估价'   => ['.info-section .price-assess>.value', 'text'],
// ])
//     ->range('.sf-pai-item-list>li') // 切片选择器
//     ->query()->getData();
// print_r($data->all());

$ql->destruct(); //释放资源，销毁内存占用

// 详情页
$url = 'https://sf-item.taobao.com/sf_item/607747368525.htm?spm=a213w.7398504.paiList.17.32a97ddatM2zOS';
$data = $ql->get($url)->rules([
    '拍卖物' => ['.pm-main', 'text'],
    // '成交价' => ['.details-main .d-m-price b', 'text'],
    // '起拍价' => ['.details-main .d-m-tb #Price_Start', 'text'],
    // '保证金' => ['.details-main .d-m-tb table>tr:eq(2)>td:eq(1)', 'text'],
    // '评估价' => ['.details-main .d-m-tb table>tr:eq(3)>td:eq(0)', 'text'],
])->encoding('UTF-8','GB2312')->queryData();
print_r($data);

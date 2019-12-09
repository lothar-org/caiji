<?php
require "../init.php";
use QL\QueryList;
use QL\Ext\PhantomJs;

/*初始化*/
$ql = QueryList::getInstance();

/*全国公共资源交易平台*/
$ql->use(PhantomJs::class, $config['jspath'], 'browser');

// 列表页
$url  = 'http://deal.ggzy.gov.cn/ds/deal/dealList.jsp?HEADER_DEAL_TYPE=01';
// $obj = $ql->browser(function (\JonnyW\PhantomJs\Http\RequestInterface $r) use ($url) {
//     $r->setMethod('GET');
//     $r->setUrl($url);
//     $r->setTimeout(10000); // 10 seconds
//     $r->setDelay(5); // 3 seconds
//     return $r;
// });
// $data = $obj->rules([
//         'title' => ['h4>a', 'text'],
//         'link'  => ['h4>a', 'href'],
//         'date'   => ['h4>.span_o', 'text'],
//         '省份'   => ['.p_tw>span:eq(1)>b', 'text'],
//         '来源平台'   => ['.p_tw>span:eq(3)', 'text'],
//         '业务类型'   => ['.p_tw>span:eq(5)', 'text'],
//         '行业'   => ['.p_tw>span:eq(9)', 'text'],
//     ])
//     ->range('#toview>.publicont') // 切片选择器
//     ->query()->getData();
// print_r($data->all());

// 通过js动态加载
// http://deal.ggzy.gov.cn/ds/deal/dealList_find.jsp
$data = file_get_contents('http://deal.ggzy.gov.cn/ds/deal/dealList_find.jsp?TIMEBEGIN_SHOW=2019-11-29&TIMEEND_SHOW=2019-12-08&TIMEBEGIN=2019-11-29&TIMEEND=2019-12-08&SOURCE_TYPE=1&DEAL_TIME=02&DEAL_CLASSIFY=01&DEAL_STAGE=0100&DEAL_PROVINCE=0&DEAL_CITY=0&DEAL_PLATFORM=0&BID_PLATFORM=0&DEAL_TRADE=0&isShowAll=1&PAGENUMBER=1&FINDTXT=');
print_r($data);
// $ql->destruct(); //释放资源，销毁内存占用

// // 详情页
// $url = 'http://www.ggzy.gov.cn/information/html/a/340000/0104/201912/05/003409cdf6bb89a74b05835b9c2f9a6c7fd7.shtml';//套用了Iframe框架
// // #iframe0104
// // $data = $ql->get($url)->getHtml();
// // print_r($data);
// // $links = $ql->get($url)->find('#iframe0104')->attrs('src');
// // print_r($links);
// $links = 'http://www.ggzy.gov.cn/information/html/b/340000/0104/201912/05/003409cdf6bb89a74b05835b9c2f9a6c7fd7.shtml';
// $data = QueryList::get($links)->rules([
//     'title' => ['#mycontent .MsoNormal:eq(0)', 'text'],
//     '项目名称' => ['.MsoNormalTable tr:eq(0) td:eq(1)', 'text'],
//     '项目编号' => ['.MsoNormalTable tr:eq(1) td:eq(1)', 'text'],
//     '招标人' => ['.MsoNormalTable tr:eq(2) td:eq(1)', 'text'],
//     '联系人' => ['.MsoNormalTable tr:eq(4) td:eq(1)', 'text'],
//     '中标价(元) ' => ['.MsoNormalTable tr:eq(11) td:eq(1)', 'text'],
//     '中标人' => ['.MsoNormalTable tr:eq(12) td:eq(2)', 'text'],
// ])->queryData();
// print_r($data);

// $data = QueryList::html($html)->rules(array(
//         'title' => array('h3','text'),
//         'list' => array('.list','html')
//     ))->range('#demo li')->queryData(function($item){
//         // 注意这里的QueryList对象与上面的QueryList对象是同一个对象
//         // 所以这里要重置range()参数，否则会共用前面的range()参数，导致出现采集不到结果的诡异现象
//         $item['list'] = QueryList::html($item['list'])->rules(array(
//                  'item' => array('.item','text')
//             ))->range('')->queryData();
//         return $item;
// });
// print_r($data);


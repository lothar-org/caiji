<?php
namespace app\index\controller;
use think\Controller;
use QL\QueryList;
use QL\Ext\PhantomJs;
use QL\Ext\AbsoluteUrl;
use QL\Ext\CurlMulti;

class Index extends Controller
{
    
    function _initialize()
    {
        # code...
    }

    public function index()
    {
       // //采集某页面所有的图片
       // $data = QueryList::get('http://cms.querylist.cc/bizhi/453.html')->find('img')->attrs('src');
       // //打印结果
       // dump($data->all());

        return $this->fetch();
        // return $this->fetch(':index');
        // return $this->display();
    }

    public function wenshu()
    {
        echo '裁判文书网：http://wenshu.court.gov.cn <br>';

        // $url = 'http://wenshu.court.gov.cn/website/wenshu/181217BMTKHNT2W0/index.html?s8=10&pageId=0.44331886654660924&sortFields=s51%3Adesc&pageNum=1&pageSize=10';//无法识别的条件
        $url = 'http://wenshu.court.gov.cn/website/wenshu/181217BMTKHNT2W0/index.html?s8=10';

        // $data = QueryList::get($url)->getHtml();
        // print_r($data);

        $ql = QueryList::getInstance();
        // 安装时需要设置PhantomJS二进制文件路径
        // $ql->use(PhantomJs::class,'/usr/local/bin/phantomjs','browser');
        // 注意：路径里面不能有空格中文之类的
        $ql->use(PhantomJs::class,'D:/dev/phantomjs/bin/phantomjs.exe');
        $ql->use(AbsoluteUrl::class,'absoluteUrl','absoluteUrlHelper');

        /*列表页*/
        // $html = $ql->browser($url)->getHtml();
        // print_r($html);

        $obj = $ql->browser(function (\JonnyW\PhantomJs\Http\RequestInterface $r) use ($url) {
            $r->setMethod('GET');
            $r->setUrl($url);
            // $r->setTimeout(10000); // 10 seconds
            $r->setDelay(2); // 3 seconds
            return $r;
        });

        // $html = $obj->getHtml();
        // print_r($html);

        // $data = $obj->find('.LM_list .list_subtitle .ah')->texts();
        // dump($data);

        $data = $obj->range('.LM_list')
            ->rules([
                'title' => ['h4>a', 'text'],
                'link'  => ['h4>a', 'href'],
                'yuan'   => ['.list_subtitle .slfyName', 'text'],
                '案号'   => ['.list_subtitle .ah', 'text'],
            ])->queryData(function ($item) use($ql){
                //使用帮助函数单独转换某个链接
                $item['link'] = $ql->absoluteUrlHelper('http://wenshu.court.gov.cn/website/wenshu/tmp/', $item['link']);
                return $item;
            });
        dump($data);

        // $ql->destruct(); //释放资源，销毁内存占用


        /*详情页*/
        // $url = 'http://wenshu.court.gov.cn/website/wenshu/181107ANFZ0BXSK4/index.html?docId=22b1b49367aa47e0befaab0b00b5badb';
        // $obj = $ql->browser(function (\JonnyW\PhantomJs\Http\RequestInterface $r) use ($url) {
        //     $r->setMethod('GET');
        //     $r->setUrl($url);
        //     $r->setTimeout(10000); // 10 seconds
        //     $r->setDelay(3); // 3 seconds
        //     return $r;
        // });
        // // $data2 = $obj->find('.del_center')->texts();
        // $data2 = $obj->find('.del_center #1')->text();
        // print_r($data2);

        foreach ($data as $v) {
            $url = $v['link'];
            $data2 = $ql->browser(function (\JonnyW\PhantomJs\Http\RequestInterface $r) use ($url) {
                $r->setMethod('GET');
                $r->setUrl($url);
                $r->setTimeout(30000); // 10 seconds
                $r->setDelay(3); // 3 seconds
                return $r;
            })
            // ->rules([
            //     'title' => ['.PDF_box .PDF_title','text'],
            //     '案号' => ['.PDF_box #1','text']
            // ])
            // ->queryData();
            ->find('.del_center #1')->text();
            dump($data2);
        }


        /*CurlMulti*/
        // $ql->use(CurlMulti::class,'curlMulti');

        // $urls = [];
        // foreach ($data as $v) {
        //     $urls[] = $v['link'];
        // }
        // $ql->rules([
        //     'title' => ['.PDF_box .PDF_title','text'],
        //     '案号' => ['.PDF_box #1','text']
        // ])
        // ->curlMulti($urls)
        // ->success(function (QueryList $ql,CurlMulti $curl,$r){
        //     echo "Current url:{$r['info']['url']} \r\n";
        //     $data2 = $ql->query()->getData();
        //     print_r($data2->all());
        //     // 释放资源
        //     $ql->destruct();
        // })->start();

    }

    /*公拍网*/
    public function gpai()
    {
        /*初始化*/
        $ql = QueryList::getInstance();

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
        dump($data->all());

        // $ql->destruct(); //释放资源，销毁内存占用

        // 详情页
        $url = 'http://www.gpai.net/sf/item2.do?Web_Item_ID=26033';
        // $data = $ql->get($url)->getHtml();
        // print_r($data);
        // 使用$ql时下面的结果始终为空！！！
        $data = QueryList::get($url)->rules([
            '拍卖物' => ['.details-main .d-m-title', 'text'],
            '成交价' => ['.details-main .d-m-price b', 'text'],
            '起拍价' => ['.details-main .d-m-tb #Price_Start', 'text'],
            '保证金' => ['.details-main .d-m-tb table>tr:eq(2)>td:eq(1)', 'text'],
            '评估价' => ['.details-main .d-m-tb table>tr:eq(3)>td:eq(0)', 'text'],
        ])->queryData(function ($item) use($ql){
            $item['保证金'] = preg_replace('/[^\d\.]/i', '', $item['保证金']);
            $item['评估价'] = preg_replace('/[^\d\.]/i', '', $item['评估价']);
            return $item;
        });
        dump($data);
    }
}

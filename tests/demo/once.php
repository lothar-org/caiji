<?php
require "../init.php";
use QL\QueryList;

/*初始化*/
$ql = QueryList::getInstance();

// $data = QueryList::get('https://www.baidu.com/s?wd=QueryList')
//       // 设置采集规则
//       ->rules([ 
//           'title'=>array('h3','text'),
//           'link'=>array('h3>a','href')
//       ])
//       ->queryData();

//   print_r($data);


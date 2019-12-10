<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// ini_set('display_errors','1');
// error_reporting(E_ALL ^ E_NOTICE);
// error_reporting(0);
header('Cache-control: private');

// [ 应用入口文件 ]

// 调试模式开关 debug.php/release.php => app_debug,app_trace
define('APP_DEBUG', true);

// 绑定入口文件到 Home 模块访问
// define('BIND_MODULE', 'admin');

// 定义根目录,可更改此目录
define('ROOT_PATH', __DIR__ . '/../');
// 定义应用目录
define('APP_PATH', ROOT_PATH . 'application/'); //改成app？
// 定义应用的运行时目录
// define('RUNTIME_PATH', ROOT_PATH . 'runtime/');

/*自定义*/
define('LANG_PATH', ROOT_PATH . 'data/lang/'); //自定义语言包路径
// 防止非法访问，代替THINK_PATH
define('IN_C2C', true);

// 加载框架引导文件
require ROOT_PATH . 'thinkphp/start.php';

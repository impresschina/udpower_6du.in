<?php
/**
 * Created by PhpStorm.
 * User: ken
 * Date: 2019-07-22
 * Time: 16:46
 */
include_once './vendor/autoload.php';
$appid = 'c81e728d9d4c2f636f067f89cc14862c';
$accesskey = '80a1ca94-6d67-36d0-b624-5eb819c38dfa';
$api = 'http://api.dove.io';//生产环境可以不用设置

//$sdk = new \Sixdu\SixduSDK($appid, $accesskey);
$sdk = new \Sixdu\SixduSDK($appid, $accesskey, $api);
$urls = ['https://github.com/impresschina/sixdu/blob/master/src/SixduSDK.php', 'https://www.baidu.com/s?ie=UTF-8&wd=6du', 'https://www.baidu.com/s?ie=utf-8&f=3&rsv_bp=1&tn=baidu&wd=spport&oq=supper&rsv_pq=ea2254360003cc1d&rsv_t=9d89EiJp0kQuRu%2Fij9g9zCX5f393qh2m4xqDGXKvhQ%2BohUVBMgIa84UK4vo&rqlang=cn&rsv_enter=1&rsv_sug3=15&rsv_sug1=13&rsv_sug7=101&rsv_sug2=0&prefixsug=sppo&rsp=0&rsv_dl=ts_0&inputT=10445&rsv_sug4=11260'];
$response = $sdk->make($urls);

var_dump($response->success, $response->status_code);
print_r(json_decode($response->body));

//for xml to array
/*
try {
    print_r($sdk->xml2array($response->body));
} catch (Exception $e) {
    print_r($e->getTraceAsString());
}*/

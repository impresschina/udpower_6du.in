<?php
/**
 * Created by PhpStorm.
 * User: ken
 * Date: 2019-07-30
 * Time: 17:25
 */


include_once './vendor/autoload.php';

const SecretKey = '54a4be329214c553ICAgICA4454d25898be4ad7gMjU4Mg';
$api = new \Sixdu\V1\SDK(SecretKey);

try {

    //创建短网址
    $body = $api->add('http://baidu.com/abc?a=1000');
    print_r($body);
    echo "\n";

    //解析短网址
    $body = $api->parse('http://6du.in/0p66kkf');
    print_r($body);
    echo "\n";

    //修改短网址
    $url = 'https://news.sina.com.cn/c/2019-07-30/doc-ihytcerm7395417.shtml';
    $body = $api->alter('http://6du.in/0p66kkf', $url);
    print_r($body);
    echo "\n";

    //统计相关 详细请查看接口文档
    $data = $api->statistics('1003', '120.85.78.109');//查询ip的信息
    $data = $api->statistics('1000', 'http://6du.in/1ob1N5i');//该短网址最近访问记录统计
    $data = $api->statistics('1001', 'http://6du.in/1ob1N5i');//详细统计
    $data = $api->statistics('1002', 'http://6du.in/1ob1N5i');//详细统计版本2

} catch (ErrorException $e) {
    echo $e->getMessage() . "\n" . $e->getTraceAsString();
    echo "\n";
}

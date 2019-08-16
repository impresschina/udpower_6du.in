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

} catch (ErrorException $e) {
    echo $e->getMessage() . "\n" . $e->getTraceAsString();
    echo "\n";
}

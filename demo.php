<?php
/**
 * Created by PhpStorm.
 * User: ken
 * Date: 2019-07-22
 * Time: 16:46
 */
include_once './vendor/autoload.php';

const SecretKey = '54a4be329214c553ICAgICA4454d25898be4ad7gMjU4Mg';
$api = new \Sixdu\API(SecretKey);

try {
    $body = $api->add('http://baidu.com/abc?a=1000');
    print_r($body);
    echo "\n";

    $short = 'http://wz4.in/1z56g';
    $body = $api->parse($short);
    print_r($body);
    echo "\n";

    $all = $api->statistics->all($short, date('Y-m-d'));
    print_r($all);
    echo "\n";

    $one = $api->statistics->one($short);
    print_r($one);
    echo "\n";

    $ip = $api->statistics->ip('120.85.77.233');
    print_r($ip);
    echo "\n";

} catch (ErrorException $e) {
    echo $e->getMessage() . "\n" . $e->getTraceAsString();
    echo "\n";
}

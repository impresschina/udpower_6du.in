 安装
------------

~~~
 composer require 6du.in/sdk
~~~

调用方法
------------
~~~
include_once './vendor/autoload.php';

const SecretKey = '54a4be329214c553ICAgICA4454d25898be4ad7gMjU4Mg';
$api = new \Sixdu\API(SecretKey);

$body = $api->add('http://baidu.com/abc?a=1000');
print_r($body);
echo "\n";
~~~
调用细节请参考相关DEMO

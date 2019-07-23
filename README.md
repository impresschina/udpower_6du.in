 安装
------------

> composer require 6du.in/sdk

调用方法
------------

```php
$appid = 'c81e728d9d4c2f636f067f89cc14862c';
$accesskey = '80a1ca94-6d67-36d0-b624-5eb819c38dfa';
$api = 'http://api.dove.io';

$sdk = new \Sixdu\SixduSDK($appid, $accesskey, $api);
$urls = ['https://...','https://...','https://...','https://...','https://...'];
$response = $sdk->make($urls);
```

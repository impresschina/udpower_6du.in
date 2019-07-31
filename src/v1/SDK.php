<?php
/**
 * Created by PhpStorm.
 * User: ken
 * Date: 2019-07-30
 * Time: 17:23
 */

namespace Sixdu\V1;


class SDK
{
    /**
     * API URL
     */
    const API = 'http://admin.6du.in/api/public/index.php';

    /**
     * statistics type
     * @var array
     */
    private $types = array('1000', '1001', '1002', '1003');

    /**
     * @var
     */
    private $query;

    /**
     * SDK constructor.
     * @param $secretKey
     */
    public function __construct($secretKey)
    {
        $this->query['secretkey'] = &$secretKey;
        $this->query['version'] = 1;
    }

    /**
     * 正常返回短网址,如果URL是一个数组时返回值就会是数组
     * @param $url
     * @param null $host 可以指定生成短网址的 host
     * @return string|array
     * @throws \ErrorException
     */
    public function add($url, $host = null)
    {
        $query = array('action' => 'add', 'url' => $url);
        if (!is_null($host))
            $query['host'] = $host;

        $request = \Requests::get($this->builder($query));

        $body = json_decode($request->body, true);
        if ($request->status_code != 200)
            $this->error($request->status_code, @$body['code'], @$body['message']);

        return $body['url'];
    }

    /**
     * @param array $query
     * @return string
     */
    private function builder($query)
    {
        return self::API . '?' . http_build_query($this->query + $query);
    }

    /**
     * @param $status
     * @param $code
     * @param $message
     * @throws \ErrorException
     */
    private function error($status, $code, $message)
    {
        throw new \ErrorException(sprintf('API request has %s error and code:"%s" message:"%s"', $status, $code, $message));
    }

    /**
     * 解析短网址为原来真实的网址
     * @param $url
     * @return mixed
     * @throws \ErrorException
     */
    public function parse($url)
    {
        $request = \Requests::get($this->builder(array('action' => 'parse', 'url' => $url)));

        $body = json_decode($request->body, true);
        if ($request->status_code != 200)
            $this->error($request->status_code, @$body['code'], @$body['message']);

        return $body['url'];
    }

    /**
     * 修改已生成短网址的目标网址
     * @param $short_url
     * @param $new_long_url
     * @return bool
     * @throws \ErrorException
     */
    public function alter($short_url, $new_long_url)
    {
        $request = \Requests::get($this->builder(array('action' => 'alter', 'surl' => $short_url, 'lurl' => $new_long_url)));
        $body = json_decode($request->body, true);
        if ($request->status_code != 200)
            $this->error($request->status_code, @$body['code'], @$body['message']);

        return $body['status'];
    }

    /**
     * 生成二维码，方法返回base64编码的图片
     * @param $url
     * @return mixed
     * @throws \ErrorException
     */
    public function qrc($url)
    {
        $request = \Requests::get($this->builder(array('action' => 'qrc', 'url' => $url)));
        $body = json_decode($request->body, true);
        if ($request->status_code != 200)
            $this->error($request->status_code, @$body['code'], @$body['message']);

        return $body['base64_image'];
    }

    /**
     * @param $type
     * @param $value
     * @return array
     * @throws \ErrorException
     */
    public function statistics($type, $value)
    {
        if (!in_array($type, $this->types))
            throw new \ErrorException('The $type parameter invalid');

        if ($type == '1003') {
            if (filter_var($value, FILTER_VALIDATE_IP) === false) {
                throw new \ErrorException('The $value parameter invalid it must be a ip address.');
            }
        }

        $request = \Requests::get($this->builder(array('action' => 'statistics', 'type' => $type, 'value' => $value)));
        $body = json_decode($request->body, true);
        if ($request->status_code != 200)
            $this->error($request->status_code, @$body['code'], @$body['message']);

        return $body;
    }
}
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
    const API = 'http://apis.6du.in/v1';

    /**
     * statistics type
     * @var array
     */
    private $types = array('1000', '1001', '1002');

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
     * @param $action
     * @param array $query
     * @return string
     */
    private function builder($action, $query)
    {
        return self::API . '/' . $action . '?' . http_build_query($this->query + $query);
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
        $query = array('url' => $url);
        if (!is_null($host))
            $query['host'] = $host;

        $request = \Requests::get($this->builder('add', $query));

        $body = json_decode($request->body, true);
        if ($request->status_code != 200)
            $this->error($request->status_code, @$body['code'], @$body['message']);

        return $body['url'];
    }

    /**
     * 解析短网址为原来真实的网址
     * @param $url
     * @return mixed
     * @throws \ErrorException
     */
    public function parse($url)
    {
        $request = \Requests::get($this->builder('parse', array('url' => $url)));

        $body = json_decode($request->body, true);
        if ($request->status_code != 200)
            $this->error($request->status_code, @$body['code'], @$body['message']);

        return $body['url'];
    }

    /**
     * IP信息查询
     * @param $address
     * @return mixed
     * @throws \ErrorException
     */
    public function ipinfo($address)
    {
        if (filter_var($address, FILTER_VALIDATE_IP) === false) {
            throw new \ErrorException('The $value parameter invalid it must be a ip address.');
        }

        $request = \Requests::get($this->builder('ipinfo', array('address' => $address)));
        $body = json_decode($request->body, true);
        if ($request->status_code != 200)
            $this->error($request->status_code, @$body['code'], @$body['message']);

        return $body;
    }

    /**
     * 短网址统计 $type 的值请查询接口文档
     * @param int $type
     * @param string $url short url
     * @return array
     * @throws \ErrorException
     */
    public function statistics($type, $url)
    {
        if (!in_array($type, $this->types))
            throw new \ErrorException('The $type parameter invalid');

        $request = \Requests::get($this->builder('statistics', array('type' => $type, 'url' => $url)));
        $body = json_decode($request->body, true);
        if ($request->status_code != 200)
            $this->error($request->status_code, @$body['code'], @$body['message']);

        return $body;
    }
}
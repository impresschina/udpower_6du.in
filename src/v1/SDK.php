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
}
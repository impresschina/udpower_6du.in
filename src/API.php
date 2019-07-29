<?php
/**
 * Created by PhpStorm.
 * User: ken
 * Date: 2019-07-26
 * Time: 09:39
 */

namespace Sixdu;

/**
 * Class API
 * @property  Statistics $statistics
 * @package Sixdu
 */
class API
{
    /**
     * API URL
     */
    const API = 'http://api.6du.in';

    /**
     * @var Statistics
     */
    private static $_statistics;

    /**
     * @var
     */
    private $query;

    /**
     * SixduAPI constructor.
     * @param $secretKey
     */
    public function __construct($secretKey)
    {
        $this->query['secretkey'] = &$secretKey;
    }

    /**
     * @param string $path
     * @param array $query
     * @return string
     */
    public function builder($path, $query)
    {
        return self::API . $path . '?' . http_build_query($this->query + $query);
    }

    /** 创建短网址请求
     * @param string $url 将要生成的短网址的网址
     * @return array
     * @throws \ErrorException
     */
    public function add($url)
    {
        $request = \Requests::get($this->builder('/urls/add', ['lurl' => $url]));
        $code = $request->status_code;
        if ($code != 200)
            throw new \ErrorException('Request has an error HTTP status code: ' . $code);

        $data = json_decode($request->body, true);
        if (is_array($data))
            return $data;

        return array('status' => 1, 'url' => $request->body);
    }

    /**
     * 解析短网址请求
     * @param string $url 已生成的短网址
     * @return array
     * @throws \ErrorException
     */
    public function parse($url)
    {
        $request = \Requests::get($this->builder('/urls/parse', ['surl' => $url]));
        $code = $request->status_code;
        if ($code != 200)
            throw new \ErrorException('Request has an error HTTP status code: ' . $code);

        $data = json_decode($request->body, true);
        if (is_array($data))
            return $data;

        return array('status' => 1, 'url' => $request->body);
    }

    /**
     * @param $name
     * @return Statistics
     */
    public function __get($name)
    {
        if ($name == 'statistics') {
            if (is_null(static::$_statistics))
                static::$_statistics = new Statistics($this);
            return static::$_statistics;
        }
        return null;
    }
}
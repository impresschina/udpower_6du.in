<?php
/**
 * Created by PhpStorm.
 * User: ken
 * Date: 2019-07-26
 * Time: 12:02
 */

namespace Sixdu\V0;

class Statistics
{
    /**
     * @var SDK
     */
    private $api;

    /**
     * Statistics constructor.
     * @param $api
     */
    public function __construct($api)
    {
        $this->api = &$api;
    }

    /**
     * 查看具体日期统计报表
     * @param string $url 短网址
     * @return bool|mixed
     * @throws \ErrorException
     */
    public function one($url)
    {
        $parser = \Sixdu\URL::parser($url);
        $request = \Requests::get($this->api->builder('/urls/one', array('code' => ltrim($parser->path, "/"))));
        $code = $request->status_code;
        if ($code != 200)
            throw new \ErrorException('Request has an error HTTP status code: ' . $code);

        $data = json_decode($request->body, true);
        if (is_array($data))
            return $data;

        return false;

    }

    /**
     * 查看所有统计报表
     * @param string $url 短网址
     * @param $begin $begin 开始统计的日期，如 2019-06-01
     * @return array|false
     * @throws \ErrorException
     */
    public function all($url, $begin)
    {
        $parser = \Sixdu\URL::parser($url);

        $time = strtotime($begin);
        if ($time === false || strtotime(date('Y-m-d')) > $time) {
            throw new \ErrorException('Please set the correct begin date parameter');
        }

        $request = \Requests::get($this->api->builder('/urls/all', array('code' => ltrim($parser->path, "/"), 'start_day' => $begin)));
        $code = $request->status_code;
        if ($code != 200)
            throw new \ErrorException('Request has an error HTTP status code: ' . $code);

        $data = json_decode($request->body, true);
        if (is_array($data))
            return $data;

        return false;
    }

    /**
     * 查询单一短网址7天访问详情
     * @param string $url 短网址
     * @return bool|mixed
     * @throws \ErrorException
     */
    public function record($url)
    {
        $parser = \Sixdu\URL::parser($url);

        $request = \Requests::get($this->api->builder('/urls/record', array('code' => ltrim($parser->path, "/"))));
        $code = $request->status_code;
        if ($code != 200)
            throw new \ErrorException('Request has an error HTTP status code: ' . $code);

        $data = json_decode($request->body, true);
        if (is_array($data))
            return $data;

        return false;

    }

    /**
     * 查询IP地址的信息，返回IP地址的国家，省份，城市，公司／单位信息，ISP接入商信息（ipip.net同步更新）
     * @param $ip
     * @return bool|mixed
     * @throws \ErrorException
     */
    public function ip($ip)
    {
        if (!filter_var($ip, FILTER_VALIDATE_IP))
            throw new \ErrorException('Please set the correct ip address');

        $request = \Requests::get($this->api->builder('/ip/find', array('ip' => $ip)));
        $code = $request->status_code;
        if ($code != 200)
            throw new \ErrorException('Request has an error HTTP status code: ' . $code);

        $data = json_decode($request->body, true);
        if (is_array($data))
            return $data;

        return false;
    }
}
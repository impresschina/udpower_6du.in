<?php
/**
 * Created by PhpStorm.
 * User: ken
 * Date: 2019-07-22
 * Time: 15:23
 */

namespace Sixdu;

use LSS\XML2Array;
use Requests;


class SixduSDK
{
    /**
     *  Default api url
     * @var string|null
     */
    private $api = 'http://api.6du.in';

    /**
     * @var
     */
    private $appid;

    /**
     * @var
     */
    private $accesskey;

    /**
     * @var array
     */
    private $supportFormats = ['json', 'xml'];

    /**
     * SixduSDK constructor.
     * @param $appid
     * @param $accesskey
     * @param null $api
     */
    public function __construct($appid, $accesskey, $api = null)
    {
        $this->appid = $appid;
        $this->accesskey = $accesskey;

        if (!is_null($api))
            $this->api = $api;
    }

    /**
     * @param $xml
     * @return array
     * @throws \Exception
     */
    public function xml2array($xml)
    {
        return XML2Array::createArray($xml)['response'];
    }

    /**
     * @param array $urls 生成短链接url
     * @param string $format 默认是json
     * @return \Requests_Response
     */
    public function make(array $urls, $format = 'json')
    {
        $data = ['urls' => $urls];
        $body = $this->builder($data, $format);
        return Requests::post($this->api . '/make', [], $body);
        //$url = $this->api . '/make?' . http_build_query($body);
        //$response = Requests::get($url);
    }

    /**
     * builder request body
     * @param array $body
     * @param $format
     * @return array
     */
    private function builder($body, $format)
    {
        //默认接口返回json数据格式
        $format = !in_array($format, $this->supportFormats) ? 'json' : $format;
        $body = ['appid' => $this->appid, 'format' => $format, 'nonce' => uniqid(), 'timestamp' => time()] + (array)$body;

        //按照参数属性名称的字母进行升序排序
        ksort($body);

        //创建请求字符串
        $query = http_build_query($body);

        //将密钥拼接请求字符串
        //md5拼接好的字符串拼转为大写得到接口请求签名
        $rawSignature = $query . '&accesskey=' . $this->accesskey;
        $signature = md5($rawSignature);

        return $body + ['signature' => $signature];
    }

}
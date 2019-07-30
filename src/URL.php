<?php
/**
 * Created by PhpStorm.
 * User: ken
 * Date: 2019-07-30
 * Time: 18:00
 */

namespace Sixdu;

/**
 * Class URL
 * @property string $scheme
 * @property string $host
 * @property string $path
 * @property string $query
 * @package Common
 */
class URL
{
    /**
     * @var URL
     */
    private static $obj;

    /**
     * @var
     */
    private static $data = array();

    /**
     * @param $url
     * @return $this
     */
    public static function parser($url)
    {
        self::$data = parse_url($url);
        if (is_null(self::$obj)) self::$obj = new self();
        return self::$obj;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        return array_key_exists($name, self::$data) ? self::$data[$name] : null;
    }

}
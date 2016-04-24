<?php

class VkApi
{
    private static $api_ver = "5.50";

    public static function getMethodUrl($method, $params)
    {
        return "https://api.vk.com/method/$method?v=" . self::$api_ver . "&" . http_build_query($params);
    }

    public static function request($url)
    {
        return json_decode(file_get_contents($url), true);
    }

    public static function findMaxSizeLink($photo)
    {
        $prefix = "photo_";
        $sizes = [2560, 1280, 807, 604, 130, 75];

        foreach ($sizes as $size) {
            if (isset($photo[$prefix . $size])) {
                return urldecode($photo[$prefix . $size]);
            }
        }

        return false;
    }
}
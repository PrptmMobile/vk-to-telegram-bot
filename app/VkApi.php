<?php

class VkApi
{
    private static $api_ver = "5.50";

    /**
     * @param $method
     * @param $params
     * @return string
     * Return url of method to request
     */
    public static function getMethodUrl($method, $params)
    {
        return "https://api.vk.com/method/$method?v=" . self::$api_ver . "&" . http_build_query($params);
    }

    /**
     * @param $url
     * @return mixed
     * Return array of vk response
     */
    public static function request($url)
    {
        return json_decode(file_get_contents($url), true);
    }

    /**
     * @param $photo
     * @return bool|string
     * Returns url of max sized available photo
     */
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

    /**
     * @param $text
     * @return mixed
     * Clears $text from vk links [club1|Test] or [id1|Test]
     */
    public static function clearVkLinks($text)
    {
        //Clear from [club]
        preg_match_all("/\[club.*\|(.*?)\]/i", $text, $vk_links);
        foreach ($vk_links[0] as $key => $vk_link) {
            $text = str_replace($vk_link, $vk_links[1][$key], $text);
        }
        $text = str_replace("", "replace", $text);

        //Clear from [id]
        preg_match_all("/\[id.*\|(.*?)\]/i", $text, $vk_links);
        foreach ($vk_links[0] as $key => $vk_link) {
            $text = str_replace($vk_link, $vk_links[1][$key], $text);
        }
        $text = str_replace("", "replace", $text);

        return $text;
    }

    /**
     * @param $text
     * @param $link
     * @return string
     * Append "Comment in vk:" to text
     */
    public static function appendLink($text, $link)
    {
        $text = self::clearVkLinks($text);
        return trim($text . " Комментировать в ВК:") . " " . $link;
    }
}
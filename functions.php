<?php

/**
 * @param $str
 * Puts str to log file
 */
function addLog($str)
{
    $str = "[" . date('H:i:s') . "]: " . $str . "\n";
    file_put_contents(Config::getFileLog(), $str, FILE_APPEND);
}

/**
 * @param array $last
 * Saves last posts' ids to .json file
 */
function saveLast($last)
{
    file_put_contents(Config::getFileLast(), json_encode($last));
}

/**
 * @param $text
 * @param $link
 * @return string
 * Append "Comment in vk:" to text
 */
function appendLink($text, $link)
{
    $text = clearVkLinks($text);
    return trim($text . " Комментировать в ВК:") . " " . $link;
}

/**
 * @param $text
 * @return mixed
 * Clears $text from vk links [club1|Test] or [id1|Test]
 */
function clearVkLinks($text)
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
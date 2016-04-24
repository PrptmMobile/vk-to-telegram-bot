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
 * @return string
 * Cuts text to 140 symbols or more till the space and add "Read more:" text
 */
function getTextPreview($text)
{
    $text = clearVkLinks($text);
    $i = 139;
    if (!isset($text[$i])) {
        return trim($text . " Комментировать в ВК:") . " ";
    }
    $max = strlen($text) - 1;
    while ($text[$i] != " " and $i < $max) {
        $i++;
    }
    $text = substr($text, 0, $i);
    return $text . "... Подробнее: ";
}

/**
 * @param $text
 * @return string
 * Append "Comment in vk:" to text
 */
function appendLink($text){
    $text = clearVkLinks($text);
    return trim($text . " Комментировать в ВК:") . " ";
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
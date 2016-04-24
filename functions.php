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


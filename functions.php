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
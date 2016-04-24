<?php
require_once "vendor/autoload.php";
require_once "Config.php";
require_once "functions.php";
require_once "VkApi.php";
require_once "TelegramApi.php";

//Get vk response
$response = VkApi::request(VkApi::getMethodUrl("wall.get", Config::getVkParams()))["response"];

//Get last posts which we have sent to Telegram
if (!file_exists(Config::getFileLast())) {
    file_put_contents(Config::getFileLast(), "[]");
}
$last = json_decode(file_get_contents(Config::getFileLast()), true);

//Check if we have some troubles, while reading from last.json
if(empty($last)){
    addLog("For some reason ".Config::getFileLast()." is empty or we can't properly read from it");
    return false;
}

//Check if we have no posts
if(empty($response["items"])){
    addLog("Fail loading data from VK");
    return false;
}

//Check posts
$parsed_ids = [];
$key = count($response["items"]) - 1;
$posted = [
    "counter" => 0,
    "ids" => []
];
$telegram = new TelegramApi();
while ($key >= 0) {
    $post = $response["items"][$key];
    //If we have matches - ignore them
    if (!in_array($post["id"], $last)) {

        $link = "https://vk.com/wall" . Config::getGroupId() . "_" . $post["id"];

        //If we have post text - send it
        if (isset($post["text"])) {
            $message = appendLink($post["text"], $link);
            $telegram->sendMessageAsUrl($message);
        }

        //If we have attachments - check them
        if (isset($post["attachments"])){
            //Scan all attachments for photos
            foreach($post["attachments"] as $attach){
                if($attach["type"]  == "photo"){
                    $telegram->sendPhoto(VkApi::findMaxSizeLink($attach["photo"]));
                }
            }
        }

        $posted["counter"]++;
        array_push($posted["ids"], $post["id"]);
    }

    //Add posted id to ids array
    array_push($parsed_ids, $post["id"]);
    $key--;
}

//Save log
if($posted["counter"] > 0){
    $log = "Add ".$posted["counter"]." new posts: " . implode(",", $posted["ids"]) . " | from last.json: " . implode(",", $last);
    addLog($log);

    //Save last
    $posts = array_merge($last, $posted["ids"]);
    saveLast($posts);
}else{
    //addLog("No new posts");
}

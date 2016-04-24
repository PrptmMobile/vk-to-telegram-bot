<?php

use Longman\TelegramBot\Request;

class TelegramApi
{
    private $telegram;

    public function __construct()
    {
        $this->telegram = new Longman\TelegramBot\Telegram(Config::getTelegramKey(), Config::getTelegramName());
    }

    /**
     * @param string $message
     * Send message with URL to the post
     */
    public function sendMessageAsUrl($message)
    {
        $result = Request::sendMessage(
            [
                'chat_id' => Config::getTelegramChat(),
                'text' => $message
            ]
        );
    }

    /**
     * @param $link
     * Send photo to channel
     */
    public function sendPhoto($link)
    {
        $file = file_put_contents(__DIR__ . time() . ".jpg", fopen($link, 'r'));
        $result = Request::sendPhoto(
            [
                'chat_id' => Config::getTelegramChat(),
            ],
            $this->telegram->getUploadPath() . $file
        );
    }
}
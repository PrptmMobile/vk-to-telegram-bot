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
        $result = Request::sendPhoto(
            [
                'chat_id' => Config::getTelegramChat(),
            ],
            $link
        );
    }
}
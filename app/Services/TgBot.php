<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TgBot
{
    public $channel;
    public $token;
    public $test_channel;
    public $test_token;

    public function __construct()
    {
        $this->token = config('services.telegram.bot_token');
        $this->channel = config('services.telegram.channel');
        $this->test_token = config('services.telegram.bot_test_token');
        $this->test_channel = config('services.telegram.channel_test');
    }

    public function sendNumToChannel($num)
    {
        $parsed = CheckNumService::getParsed($num);
        $region = $parsed['region'];
        $letter = $parsed['letter'];
        $digits = $parsed['digits'];
        $series = $parsed['series'];

        // Hashtaglar
        $regionName = CheckNumService::getRegionName($region);

        $hashtags = "#{$regionName}" . ($digits ? " #{$digits}" : '');

        $formatted = CheckNumService::parseNum($num);
        $message = "
        🚗 <b>Yangi avtomobil raqami!</b>\n
<b>$formatted</b>\n
📅 " . now()->format('d.m.Y H:i') . "\n" . "$hashtags";
        try {
            Http::get("https://api.telegram.org/bot{$this->token}/sendMessage", [
                'chat_id' => $this->channel,
                'text' => $message,
                'parse_mode' => 'HTML',
            ]);
            return true;
        }  catch (\Exception $e) {
            return false;
        }
    }

    public function sendNumToChannelTest($num)
    {
        $parsed = CheckNumService::getParsed($num);
        $region = $parsed['region'];
        $letter = $parsed['letter'];
        $digits = $parsed['digits'];
        $series = $parsed['series'];

        // Hashtaglar
        $regionName = CheckNumService::getRegionName($region);

        $hashtags = "#{$regionName}" . ($digits ? " #{$digits}" : '');

        $formatted = CheckNumService::parseNum($num);
        $message = "
        🚗 <b>Yangi avtomobil raqami!</b>\n
<b>$formatted</b>\n
📅 " . now()->format('d.m.Y H:i') . "\n" . "$hashtags";
        try {
            Http::get("https://api.telegram.org/bot{$this->test_token}/sendMessage", [
                'chat_id' => $this->test_channel,
                'text' => $message,
                'parse_mode' => 'HTML',
            ]);
            return true;
        }  catch (\Exception $e) {
            return false;
        }
    }
}

<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TgBot
{
    public $channel;
    public $token;
    public function __construct()
    {
        $this->token = config('services.telegram.bot_token');
        $this->channel = config('services.telegram.channel');
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
}

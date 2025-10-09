<?php

namespace App\Console\Commands;

use App\Services\CheckNumService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CheckFake extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-fake';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $result = CheckNumService::checkFake();
        if ($result['ok'] and $result['data']['message'] == 'Data found') {
            $token = '5187500736:AAFKPS7wqTn-0lTsZVEZyZ81IMsQbodtPRk';
            $chatId = '291096722';
            $url = "https://api.telegram.org/bot{$token}/sendMessage";

            $resp = Http::asForm()->post($url, [
                'chat_id' => $chatId,
                'text' => 'Data found',
                'parse_mode' => 'HTML',
                'disable_web_page_preview' => true,
            ]);
        }
    }
}

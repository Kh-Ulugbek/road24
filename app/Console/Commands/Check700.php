<?php

namespace App\Console\Commands;

use App\Services\CheckNumService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class Check700 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check700';

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
        $result = CheckNumService::checkTest();
        if ($result['ok'] and $result['data']['message'] == 'Data found') {
            $token = '5187500736:AAFKPS7wqTn-0lTsZVEZyZ81IMsQbodtPRk';
            $chatId = '291096722';
            $url = "https://api.telegram.org/bot{$token}/sendMessage";

            foreach ($result['data']['data'] as $value) {
                $resp = Http::asForm()->post($url, [
                    'chat_id' => $chatId,
                    'text' => $value['drbNumber'] . ' ' . '🔵',
                    'parse_mode' => 'HTML',
                    'disable_web_page_preview' => true,
                ]);
            }
        }
    }
}

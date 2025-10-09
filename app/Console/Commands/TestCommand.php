<?php

namespace App\Console\Commands;

use App\Services\CheckNumService;
use App\Services\TgBot;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-command';

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
        $result = CheckNumService::check(100);
        if ($result['ok'] and $result['data']['message'] == 'Data found') {
            CheckNumService::sendNums($result['data']['data']);
        }
    }
}

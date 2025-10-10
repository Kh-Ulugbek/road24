<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Purchase
{
    public static function purchase($value)
    {
        try {
            $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MzU3OTE5LCJpYXQiOjE3NTk0NjYwMzMsImV4cCI6MTc2MjkyMjAzM30.AIMb3N2qqLVnVwNvYUPvTM1fpXDFxcIziMecJx5MBdY';
            $headers = [
                'Accept' => '*/*',
                'Accept-Language' => 'uz',
                'Authorization' => 'Bearer ' . $token,
                'x-os' => 'ios',
                'x-device-name' => 'iPhone 14 Pro Max',
                // siz haqiqiy device id qo'ying yoki dinamik o'zgartiring
                'x-device-id' => 'AB85C572-CE2B-44D7-A798-AD0043E27E6C',
                'User-Agent' => 'SafeRoad/1.6.1 (iOS/18.5; build=9; device=iPhone 14 Pro Max)',
                'x-app-version' => '1.6.1',
            ];

            $response = Http::withHeaders($headers)
                ->get('https://app.road247.uz/api/get-infinity-pay-public-offer/uz?');
            sleep(1);

            if ($response->successful()) {
                $data = [
                    "docId" => "30210996600044",
                    "plateId" => $value['drbId'],
                    "plateNumber" => $value['drbNumber'],
                    "ownerName" => "ULUG‘BEK XOLIQULOV BAXTIYOR O‘G‘LI",
                    "filialId" => $value['filial']['id'],
                    "phoneNumber" => "998996078774",
                    "isRectangle" => false,
                    "amount" => 7004000,
                    "ownerTypeId" => 2,
                    "comment" => "",
                    "regionId" => 10,
                    "isElectr" => false,
                    "cityId" => 0
                ];
                $r = Http::withHeaders($headers)
                    ->post('https://app.road247.uz/api/car-plate-purchase/create-order-plate-purchase', $data);
                if ($r->successful()) {
                    Log::error('Olindi');
                }

            } else {
                Log::error('Telegram xabar yuborishda xato ' . $value['drbNumber'] . ' // ' . $response->getStatusCode());
            }
        } catch (\Exception $exception) {
            Log::error('Telegram xabar yuborishda xato ' . $value['drbNumber'] . ' // ' . $exception->getMessage() . ' // ' . $exception->getFile() . ' // ' . $exception->getLine());
        }

    }
}

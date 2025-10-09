<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckNumService
{
    public static function check($num)
    {
        // Paramlar — o'zgartiring yoki $request orqali oling
        $params = [
            'page' => 1,
            'size' => 10,
            // agar original so'rovdagi kabi '%' belgilarini yubormoqchi bo'lsangiz, raw string ham yetadi:
            // 'plateNumber' => '01%100%%'
            // yoki aniq encoded ko'rinishni yubormoqchi bo'lsangiz:
            // 'plateNumber' => rawurlencode('01%100%%') // natija 01%25100%25%25
            'plateNumber' => '01%' . $num . '%%',
            'ownerTypeId' => 2,
            'regionId' => 10,
            'isElectr' => 'false',
            'isRectangle' => 'false',
        ];

        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MzU3OTE5LCJpYXQiOjE3NTk0NjYwMzMsImV4cCI6MTc2MjkyMjAzM30.AIMb3N2qqLVnVwNvYUPvTM1fpXDFxcIziMecJx5MBdY';

        $headers = [
            'Accept' => '*/*',
            'Accept-Language' => 'uz',
            'Authorization' => 'Bearer ' . $token,
            'x-os' => 'ios',
            'x-device-name' => 'iPhone 14 Pro Max',
            // siz haqiqiy device id qo'ying yoki dinamik o'zgartiring
            'x-device-id' => 'AB85C572-CE2B-44D7-A798-AD0043E27E6C',
            'User-Agent' => 'SafeRoad/1.6.0 (iOS/18.5; build=7; device=iPhone 14 Pro Max)',
            'x-app-version' => '1.6.0',
        ];

        $response = Http::withHeaders($headers)
            // agar HTTP/2 kerak bo'lsa Guzzle avtomatik qo'llab-quvvatlaydi
            ->get('https://app.road247.uz/api/car-plate-purchase/search-plate-number', $params);

        // status code tekshir
        if ($response->successful()) {
            $data = $response->json(); // array yoki object
            // log yoki qaytarish
            return [
                'ok' => true,
                'data' => $data,
            ];
        } else {
            return [
                'ok' => false,
                'data' => null,
            ];
        }

    }

    public static function sendNums($nums)
    {
        foreach ($nums as $value) {
            try {
                $tg = new TgBot();
                $tg->sendNumToChannel($value['drbNumber']);
            } catch (\Exception $e) {
                Log::error('Telegram xabar yuborishda xato ' . $value['drbNumber'] . ' // ' . $e->getMessage() . ' // ' . $e->getFile() . ' // ' . $e->getLine());
            }
        }
    }

    public static function sendNumsTest($nums)
    {
        foreach ($nums as $value) {
            try {
                $tg = new TgBot();
                $tg->sendNumToChannelTest($value['drbNumber']);
            } catch (\Exception $e) {
                Log::error('Telegram xabar yuborishda xato ' . $value['drbNumber'] . ' // ' . $e->getMessage() . ' // ' . $e->getFile() . ' // ' . $e->getLine());
            }
        }
    }

    public static function parseNum($number)
    {
        // Bo‘sh joylar yoki kichik harflarni tozalaymiz
        $number = strtoupper(trim($number));

        // Regex orqali ajratamiz: 2 raqam, 1 harf, 3 raqam, 2 harf
        if (preg_match('/^(\d{2})([A-Z])(\d{3})([A-Z]{2})$/', $number, $m)) {
            // 01 A 777 AA
            $region = $m[1];
            $letter = $m[2];
            $digits = $m[3];
            $series = $m[4];
            if ($digits == '777') {
                $color = '🟢';
            } elseif ($digits == '007') {
                $color = '🔵';
            } elseif ($digits == '700') {
                $color = '🔴';
            } elseif ($digits == '001') {
                $color = '🟡';
            } else {
                $color = '⚫️';
            }


            return "$color {$region} {$letter} {$digits} {$series} 🇺🇿";
        }

        // Agar mos tushmasa, oddiy ko‘rsatamiz
        return "{$number}";
    }

    public static function getParsed($number)
    {
        // Bo‘sh joylar yoki kichik harflarni tozalaymiz
        $number = strtoupper(trim($number));

        // Regex orqali ajratamiz: 2 raqam, 1 harf, 3 raqam, 2 harf
        if (preg_match('/^(\d{2})([A-Z])(\d{3})([A-Z]{2})$/', $number, $m)) {
            // 01 A 777 AA
            $region = $m[1];
            $letter = $m[2];
            $digits = $m[3];
            $series = $m[4];

            return [
                'region' => $m[1],
                'letter' => $m[2],
                'digits' => $m[3],
                'series' => $m[4],
            ];
        } else {
            return false;
        }
    }

    public static function getRegionName(string $code): string
    {
        $regions = [
            '01' => 'Toshkent',
            '10' => 'Qoraqalpog‘iston',
            '20' => 'Samarqand',
            '25' => 'Surxondaryo',
            '30' => 'Farg‘ona',
            '40' => 'Namangan',
            '50' => 'Andijon',
            '60' => 'Buxoro',
            '70' => 'Navoiy',
            '75' => 'Jizzax',
            '80' => 'Sirdaryo',
            '85' => 'Qashqadaryo',
            '90' => 'Xorazm',
        ];

        return $regions[$code] ?? 'Uzbekistan';
    }

    public static function checkFake()
    {
        // Paramlar — o'zgartiring yoki $request orqali oling
        $params = [
            'page' => 1,
            'size' => 10,
            // agar original so'rovdagi kabi '%' belgilarini yubormoqchi bo'lsangiz, raw string ham yetadi:
            // 'plateNumber' => '01%100%%'
            // yoki aniq encoded ko'rinishni yubormoqchi bo'lsangiz:
            // 'plateNumber' => rawurlencode('01%100%%') // natija 01%25100%25%25
            'plateNumber' => '01%100%%',
            'ownerTypeId' => 2,
            'regionId' => 10,
            'isElectr' => 'false',
            'isRectangle' => 'false',
        ];

        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MzU3OTE5LCJpYXQiOjE3NTk0NjYwMzMsImV4cCI6MTc2MjkyMjAzM30.AIMb3N2qqLVnVwNvYUPvTM1fpXDFxcIziMecJx5MBdY';

        $headers = [
            'Accept' => '*/*',
            'Accept-Language' => 'uz',
            'Authorization' => 'Bearer ' . $token,
            'x-os' => 'ios',
            'x-device-name' => 'iPhone 14 Pro Max',
            // siz haqiqiy device id qo'ying yoki dinamik o'zgartiring
            'x-device-id' => 'AB85C572-CE2B-44D7-A798-AD0043E27E6C',
            'User-Agent' => 'SafeRoad/1.6.0 (iOS/18.5; build=7; device=iPhone 14 Pro Max)',
            'x-app-version' => '1.6.0',
        ];

        $response = Http::withHeaders($headers)
            // agar HTTP/2 kerak bo'lsa Guzzle avtomatik qo'llab-quvvatlaydi
            ->get('https://app.road247.uz/api/car-plate-purchase/search-plate-number', $params);

        // status code tekshir
        if ($response->successful()) {
            $data = $response->json(); // array yoki object
            // log yoki qaytarish
            return [
                'ok' => true,
                'data' => $data,
            ];
        } else {
            return [
                'ok' => false,
                'data' => null,
            ];
        }

    }
}

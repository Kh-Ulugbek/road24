<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CheckNumService
{
    public static function check()
    {
        // Paramlar — o'zgartiring yoki $request orqali oling
        $params = [
            'page' => 1,
            'size' => 10,
            // agar original so'rovdagi kabi '%' belgilarini yubormoqchi bo'lsangiz, raw string ham yetadi:
            // 'plateNumber' => '01%100%%'
            // yoki aniq encoded ko'rinishni yubormoqchi bo'lsangiz:
            // 'plateNumber' => rawurlencode('01%100%%') // natija 01%25100%25%25
            'plateNumber' => '01%777%%',
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

    public static function checkTest()
    {
        // Paramlar — o'zgartiring yoki $request orqali oling
        $params = [
            'page' => 1,
            'size' => 10,
            // agar original so'rovdagi kabi '%' belgilarini yubormoqchi bo'lsangiz, raw string ham yetadi:
            // 'plateNumber' => '01%100%%'
            // yoki aniq encoded ko'rinishni yubormoqchi bo'lsangiz:
            // 'plateNumber' => rawurlencode('01%100%%') // natija 01%25100%25%25
            'plateNumber' => '01%007%%',
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

    public static function checkTest700()
    {
        // Paramlar — o'zgartiring yoki $request orqali oling
        $params = [
            'page' => 1,
            'size' => 10,
            // agar original so'rovdagi kabi '%' belgilarini yubormoqchi bo'lsangiz, raw string ham yetadi:
            // 'plateNumber' => '01%100%%'
            // yoki aniq encoded ko'rinishni yubormoqchi bo'lsangiz:
            // 'plateNumber' => rawurlencode('01%100%%') // natija 01%25100%25%25
            'plateNumber' => '01%700%%',
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

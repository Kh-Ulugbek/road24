<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;

class TestController extends Controller
{
    public function test($num)
    {
        // Paramlar — o'zgartiring yoki $request orqali oling
        $params = [
            'page' => 1,
            'size' => 10,
            // agar original so'rovdagi kabi '%' belgilarini yubormoqchi bo'lsangiz, raw string ham yetadi:
            // 'plateNumber' => '01%100%%'
            // yoki aniq encoded ko'rinishni yubormoqchi bo'lsangiz:
            // 'plateNumber' => rawurlencode('01%100%%') // natija 01%25100%25%25
            'plateNumber' => '01%'.$num.'%%',
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
            return response()->json([
                'ok' => true,
                'data' => $data,
            ], 200);
        } else {
            return response()->json([
                'ok' => false,
                'data' => null,
            ], 200);
        }
    }

    public function testCheck()
    {
        // Artisan komandani chaqirish
        Artisan::call('app:check-num-test');
    }
}

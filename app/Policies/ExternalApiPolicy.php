<?php

namespace App\Policies;

use GuzzleHttp;
use App\Models\Order;

class ExternalApiPolicy {
    private static $client = null;

    public static function postOrder(Order $order) {
        if (self::$client === null) {
            self::$client = new GuzzleHttp\Client();
        }

        $updateMethods = ['updateServer1', 'updateServer2', 'updateServer3'];
        foreach ($updateMethods as $update) {
            try {
                $res = self::$update($order);
            } catch (\Exception $e) {
                \Log::error("Request feita pelo método $update não pôde ser realizada.");
                $errorOccurred = true;
            }
        }
        self::$client = null;
    }

    public static function updateServer1(Order $order) {
        $date = $order->date;
        return self::$client->post('https://localhost:9001/order', [
            'json' => [
                'OrderId' => $order->id,
                'OrderCode' => substr($date, 0, strlen($date)-3) . '-' . $order->id,
                'OrderDate' => $date,
                'TotalAmountWithoutDiscount' => $order->total + $order->discount,
                'TotalAmountWithDiscount' => $order->total,
            ]
        ]);
    }

    public static function updateServer2(Order $order) {
        $date = $order->date;
        return self::$client->post('https://localhost:9002/v1/order', [
            'json' => [
                'id' => $order->id,
                'code' => substr($date, 0, strlen($date)-3) . '-' . $order->id,
                'date' => $date,
                'total' => $order->total + $order->discount,
                'discount' => $order->discount,
            ]
        ]);
    }

    public static function updateServer3(Order $order) {
        $date = $order->date;
        return self::$client->post('https://localhost:9003/web_api/order', [
            'json' => [
                'id' => $order->id,
                'code' => substr($date, 0, strlen($date)-3) . '-' . $order->id,
                'date' => $date,
                'totalAmount' => $order->total + $order->discount,
                'totalAmountWithDiscount' => $order->total,
            ]
        ]);
    }
}

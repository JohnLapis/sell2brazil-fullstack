<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Policies\DiscountPolicy;
use Carbon\Carbon;


function hasTwoDecimals($n)
{
    return floor($n * 100) / 100 == $n;
}

function is_price($n) {
    return is_int($n) || is_float($n);
}

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['date', 'total', 'discount'];
    protected $dateFormat = 'Y-m-d';

    public static function createOrder($products)
    {
        return Order::create(Order::make($products));
    }

    public static function make($products)
    {
        $aggregated_products = [];
        $totalWithoutDiscount = 0;
        $discounted = 0;
        foreach ($products as $p) {
            $aggregated_products[$p['ArticleCode']] = $p;
            $aggregated_products[$p['ArticleCode']]['Quantity'] = 0;
        }
        foreach ($products as $p) {
            $aggregated_products[$p['ArticleCode']]['Quantity'] += $p['Quantity'];
        }
        foreach ($aggregated_products as $p) {
            foreach (DiscountPolicy::getInstance()->rules as [$discount, $isAppliable]) {
                if ($isAppliable($p)) {
                    $discounted += $discount * $p['Quantity'] * $p['UnitPrice'];
                }
                $totalWithoutDiscount += $p['Quantity'] * $p['UnitPrice'];
            }
        }

        return [
            'date' => Carbon::today()->format('Y-m-d'),
            'total' => $totalWithoutDiscount - $discounted,
            'discount' => $discounted,
        ];
    }

    public static function isValid($products) {
        foreach ($products as $p) {
            if ($p['ArticleName'] === ''
                || $p['ArticleCode'] === ''
                || !is_int($p['Quantity']) || $p['Quantity'] <= 0
                || !is_price($p['UnitPrice']) || $p['UnitPrice'] <= 0
                || !hasTwoDecimals($p['UnitPrice'])) {
                return false;
            }
        }
        return true;
    }
}

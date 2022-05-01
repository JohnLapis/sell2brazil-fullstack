<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Policies\DiscountPolicy;
use App\Models\Order;
use Database\Factories\ProductFactory;

function aggregate_products($products)
{
    $aggregated_products = [];
    foreach ($products as $p) {
        $aggregated_products[$p['ArticleCode']] = [
            'UnitPrice' => $p['UnitPrice'],
            'Quantity' => 0,
        ];
    }
    foreach ($products as $p) {
        $aggregated_products[$p['ArticleCode']]['Quantity'] += $p['Quantity'];
    }
    return $aggregated_products;
}

class OrderTest extends TestCase
{
    public function test_15_percent_discount_rule()
    {
        $isAppliable = array_filter(
            DiscountPolicy::getInstance()->rules,
            function($rule) {return $rule[0] === 0.15;}
        )[0][1];
        $products = (new ProductFactory())->count(rand(1, 5))->make();
        $discounted = array_sum(array_map(
            function($p) {return 0.15 * $p['Quantity'] * $p['UnitPrice'];},
            array_filter(aggregate_products($products->all()), $isAppliable),
        ));
        $this->assertEquals(Order::make($products)['discount'], $discounted);
    }
}

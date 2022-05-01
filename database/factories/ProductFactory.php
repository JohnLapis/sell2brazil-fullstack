<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // With only 1 character, it's more likely that two article codes will
            // be equal.
            "ArticleCode" => strval(rand(0, 9)),
            "ArticleName" => Str::random(10),
            "UnitPrice" => rand(1, 1000) + rand(0, 99) / 100,
            "Quantity" => rand(1, 13),
        ];
    }
}

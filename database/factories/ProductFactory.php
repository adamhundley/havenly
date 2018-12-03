<?php

use Faker\Generator as Faker;
use App\Product;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'sku' => $faker->ean8,
        'title' => $faker->title,
        'price' => $faker->randomNumber(2),
        'description' => $faker->sentence,
        'availability' => $faker->boolean(50),
        'color' => $faker->colorName,
        'diminsions' => $faker->randomNumber(2) . " x " . $faker->randomNumber(2),
    ];
});

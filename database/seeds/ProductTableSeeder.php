<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            Product::create([
                'sku' => $faker->ean8,
                'title' => $faker->title,
                'price' => $faker->randomNumber(2),
                'description' => $faker->sentence,
                'availability' => $faker->boolean(50),
                'color' => $faker->colorName,
                'diminsions' => $faker->randomNumber(2) . " x " . $faker->randomNumber(2),
            ]);
        }
    }
}

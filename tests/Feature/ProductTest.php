<?php

namespace Tests\Feature;

use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    public function testsProductsAreCreatedCorrectly()
    {
        $payload = [
            'sku' => '99999',
            'title' => 'Test Product',
            'price' => 19.82,
            'description' => 'This is a product description',
            'availability' => true,
            'color' => 'green',
            'diminsions' => '20 x 20'
        ];

        $this->json('POST', '/api/products', $payload)
            ->assertStatus(201)
            ->assertJson([
                'sku' => '99999',
                'title' => 'Test Product',
                'price' => 19.82,
                'description' => 'This is a product description',
                'availability' => true,
                'color' => 'green',
                'diminsions' => '20 x 20'
            ]);
    }

    public function testsProductsAreUpdatedCorrectly()
    {
        $product = factory(Product::class)->create([
            'sku' => '99999',
            'title' => 'First Product',
            'price' => 19.82,
            'description' => 'This is a first product description',
            'availability' => true,
            'color' => 'green',
            'diminsions' => '20 x 20'
        ]);

        $payload = [
            'price' => 15.72,
            'availability' => false,
        ];

        $response = $this->json('PUT', '/api/products/' . $product->id, $payload)
            ->assertStatus(200)
            ->assertJson([
                'id' => 1,
                'price' => 15.72,
                'availability' => false,
            ]);
    }

    public function testsProductsAreDeletedCorrectly()
    {
        $product = factory(Product::class)->create([
            'sku' => '99999',
            'title' => 'First Product',
            'price' => 19.82,
            'description' => 'This is a first product description',
            'availability' => true,
            'color' => 'green',
            'diminsions' => '20 x 20'
        ]);

        $this->json('DELETE', '/api/products/' . $product->id, [])
            ->assertStatus(204);
    }

    public function testProductsAreListedCorrectly()
    {
        factory(Product::class)->create([
            'sku' => '99999',
            'title' => 'First Product',
            'price' => 19.82,
            'description' => 'This is a first product description',
            'availability' => true,
            'color' => 'green',
            'diminsions' => '20 x 20'
        ]);

        factory(Product::class)->create([
            'sku' => '97799',
            'title' => 'Second Product',
            'price' => 19.89,
            'description' => 'This is a second product description',
            'availability' => false,
            'color' => 'blue',
            'diminsions' => '30 x 20'
        ]);

        $response = $this->json('GET', '/api/products', [])
            ->assertStatus(200)
            ->assertJson([
                [
                    'sku' => '99999',
                    'title' => 'First Product',
                    'price' => 19.82,
                    'description' => 'This is a first product description',
                    'availability' => true,
                    'color' => 'green',
                    'diminsions' => '20 x 20'
                ],
                [
                    'sku' => '97799',
                    'title' => 'Second Product',
                    'price' => 19.89,
                    'description' => 'This is a second product description',
                    'availability' => false,
                    'color' => 'blue',
                    'diminsions' => '30 x 20'
                ]
            ])
            ->assertJsonStructure([
                '*' => ['id', 'sku', 'title', 'price', 'description', 'availability', 'color', 'diminsions', 'created_at', 'updated_at'],
            ]);
    }
}

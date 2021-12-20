<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    
    public function test_example()
    {
             $data = [
            'name' => $this->faker->sentence,
            'image' => $this->faker->imageUrl($width = 200, $height = 200),
            'quantity' => $this->faker->numberBetween($min = 1, $max = 100),
            'price' => $this->faker->numberBetween($min = 1, $max = 1000),
            'detail' => $this->faker->paragraph,
        ];

        $this->post(route('products.store'), $data)
            ->assertStatus(201)
            ->assertJson($data);

        $response->assertStatus(200);
    }
}

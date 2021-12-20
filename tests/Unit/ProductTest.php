<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Product;

class ProductTest extends TestCase
{
      public function test_can_create_product() {

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
    }

    public function test_can_update_product() {

        $post = factory(Product::class)->create();

        $data = [
            'name' => $this->faker->sentence,
            'image' => $this->faker->imageUrl($width = 200, $height = 200),
            'quantity' => $this->faker->numberBetween($min = 1, $max = 100),
            'price' => $this->faker->numberBetween($min = 1, $max = 1000),
            'detail' => $this->faker->paragraph,
        ];

        $this->put(route('products.update', $post->id), $data)
            ->assertStatus(200)
            ->assertJson($data);
    }

    public function test_can_show_product() {

        $post = factory(Product::class)->create();

        $this->get(route('products.show', $post->id))
            ->assertStatus(200);
    }

    public function test_can_delete_product() {

        $post = factory(Product::class)->create();

        $this->delete(route('products.delete', $post->id))
            ->assertStatus(204);
    }

    public function test_can_list_product() {
        $products = factory(Product::class, 2)->create()->map(function ($post) {
            return $post->only(['id', 'name', 'detail']);
        });

        $this->get(route('products'))
            ->assertStatus(200)
            ->assertJson($products->toArray())
            ->assertJsonStructure([
                '*' => [ 'id', 'name', 'detail' ],
            ]);
    }
}

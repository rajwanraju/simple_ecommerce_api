<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;


class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $factory->define(App\Models\Products::class, function (Faker $faker) {
    return [
           'name' => $this->faker->sentence,
            'image' => $this->faker->imageUrl($width = 200, $height = 200),
            'quantity' => $this->faker->numberBetween($min = 1, $max = 100),
            'price' => $this->faker->numberBetween($min = 1, $max = 1000),
            'detail' => $this->faker->paragraph,
    ];
});
    }
}

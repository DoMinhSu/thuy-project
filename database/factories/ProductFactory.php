<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->sentence(10),
            'quantity'=>rand(1,200),
            'image'=>'',
            'sku'=>$this->faker->unique()->sentence(15),
            'price'=>rand(100,1000),
            'description'=>$this->faker->paragraph(3),
            'content'=>$this->faker->randomHtml(6,20),
            'category_id'=>rand(1,3)
        ];
    }
}

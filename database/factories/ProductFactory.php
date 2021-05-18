<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

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
        $categoryPicture = $this->faker->randomElement(['businnes', 'technics', 'city']);
        
        return [
            'name'          => $this->faker->sentence,
            'description'   => $this->faker->paragraph,
            'picture'       => $this->faker->image(storage_path().'/app/public/products', 600, 350, $categoryPicture, false),
            'price'         => $this->faker->randomFloat(2, 5, 30),
            'created_at'    => Carbon::now()
        ];
    }
}

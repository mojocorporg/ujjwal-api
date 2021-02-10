<?php

namespace Database\Factories;

use App\Models\Business;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusinessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Business::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_name' => $this->faker->company,
            'owner_name' => $this->faker->name,
            'description' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'address' => $this->faker->address,
            'pincode' => $this->faker->postcode,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'lat' => $this->faker->latitude($min = -90, $max = 90),
            'long' => $this->faker->longitude($min = -180, $max = 180),
            'status' => 1,
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Cars;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cars::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "brand" => $this->faker->text(30),
            "model" => $this->faker->text(10),
            "vin" => $this->faker->text(5),
            "body_type" => $this->faker->text(30),
            "engine_type" => $this->faker->text(30),
            "drive_type" => $this->faker->text(30),
            "gearbox_type" => $this->faker->text(30),
            "year" => $this->faker->numberBetween(1900,2021),
            "price" => $this->faker->numberBetween(100,10000),
            "mileage" => $this->faker->numberBetween(0,20000), // для подержаных
            "ownercount" => $this->faker->numberBetween(1,30),
            //
        ];
    }
}

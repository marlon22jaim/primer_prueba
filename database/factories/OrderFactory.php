<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Supplier;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status =$this->faker->randomElement(['Pending', 'Processing', 'Completed']);
        return [
            //
            'supplier_id' => Supplier::factory(),
            'amount' => $this->faker->numberBetween(100, 20000),
            'status' => $status,
            'billed_dated' => $this->faker->dateTimeThisDecade(),
            'paid_dated' => $status == 'Completed' ? $this->faker->dateTimeThisDecade() : null,

        ];
    }
}

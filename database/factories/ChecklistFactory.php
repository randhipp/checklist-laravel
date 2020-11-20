<?php

namespace Database\Factories;

use App\Models\Checklist;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ChecklistFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Checklist::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'object_domain' => 'contact',
            'object_id' => $this->faker->numberBetween($min = 1, $max = 9999),
            'description' => $this->faker->name,
            'due_interval' => $this->faker->randomDigitNotNull(),
            'due_unit' => 'hour',
            'urgency' => $this->faker->randomDigitNotNull(),
            'is_completed' => 0
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Checklist;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'checklist_id' => Checklist::factory(),
            'description' => $this->faker->name,
            'urgency' => $this->faker->randomDigitNotNull(),
            'due_interval' => $this->faker->numberBetween($min = 1, $max = 60),
            'due_unit' => 'minute'
        ];
    }
}

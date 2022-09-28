<?php

namespace Database\Factories;

use App\Models\Score;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ScoreFactory extends Factory
{

    protected $model = Score::class;
    /**
     * Define the model's default state.
*
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'score' => $this->faker->unique()->numberBetween(1000,10000),
        ];
    }
}

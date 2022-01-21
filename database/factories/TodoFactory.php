<?php

namespace Database\Factories;

use App\Models\Todo;
use Illuminate\Database\Eloquent\Factories\Factory;

class TodoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Todo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
                'description' => $this->faker->paragraph($nbSentences = 3, $variableNbSentences = true),
                'date' => $this->faker->date,
                'time' => $this->faker->time,
                'user_id' => 1,
                'sending_status' => Todo::EMAIL_NOT_SENT,
        ];
    }
}

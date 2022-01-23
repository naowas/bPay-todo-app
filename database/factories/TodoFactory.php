<?php

namespace Database\Factories;

use App\Models\Todo;
use Carbon\Carbon;
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
            'title' => $this->faker->sentence(6, true),
                'description' => $this->faker->paragraph(3, true),
                'date' => $this->faker->dateTimeThisYear('+1 year')->format('Y-m-d'),
                'time' => $this->faker->dateTimeThisYear('+1 year')->format('h:i A'),
                'user_id' => 1,
                'notification_status' => Todo::EMAIL_NOT_SENT,
        ];
    }
}

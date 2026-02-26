<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use App\Models\Lesson;
use App\Models\LessonProgress;

/**
 * @extends BaseFactory<LessonProgress>
 */
class LessonProgressFactory extends BaseFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startedAt = $this->faker->dateTimeBetween('-1 month');

        return [
            'user_id' => User::factory(),
            'lesson_id' => Lesson::factory(),
            'started_at' => $startedAt,
            'completed_at' => $this->faker->optional(0.7)->dateTimeBetween($startedAt),
        ];
    }
}

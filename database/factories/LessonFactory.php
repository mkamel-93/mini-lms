<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Course;
use App\Models\Lesson;
use App\Enums\StatusEnum;

/**
 * @extends BaseFactory<Lesson>
 */
class LessonFactory extends BaseFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->unique()->sentence(3);

        return [
            'course_id' => Course::factory(),
            'title' => $title,
            'video_url' => $this->faker->url(),
            'order' => $this->faker->numberBetween(1, 100),
            'status' => fake()->randomElement(StatusEnum::cases()),
            'is_preview' => false,
        ];
    }
}

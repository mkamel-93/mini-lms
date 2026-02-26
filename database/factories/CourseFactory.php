<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Course;
use App\Enums\StatusEnum;
use Illuminate\Support\Str;
use App\Enums\CourseLevelEnum;

/**
 * @extends BaseFactory<Course>
 */
class CourseFactory extends BaseFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->unique()->sentence(2);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'status' => fake()->randomElement(StatusEnum::cases()),
            'level' => $this->faker->randomElement(CourseLevelEnum::cases()),
        ];
    }
}

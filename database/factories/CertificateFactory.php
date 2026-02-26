<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use App\Models\Course;
use App\Models\Certificate;

/**
 * @extends BaseFactory<Certificate>
 */
class CertificateFactory extends BaseFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'course_id' => Course::factory(),
        ];
    }
}

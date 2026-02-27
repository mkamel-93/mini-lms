<?php

declare(strict_types=1);

namespace Tests\Feature\Lessons;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LessonAccessTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_view_lesson_belonging_to_correct_course(): void
    {
        $course = Course::factory()->create();
        $lesson = Lesson::factory()->create([
            'course_id' => $course->id,
            'is_preview' => true,
        ]);

        $response = $this->get(route('courses.lessons.show', [$course->slug, $lesson->id]));
        $response->assertOk();
    }

    #[Test]
    public function it_allows_guest_to_view_preview_lesson(): void
    {
        $course = Course::factory()->create();
        $lesson = Lesson::factory()->create([
            'course_id' => $course->id,
            'is_preview' => true,
        ]);

        $response = $this->get(route('courses.lessons.show', [$course->slug, $lesson->id]));

        $response->assertOk();
    }

    #[Test]
    public function it_denies_guest_from_viewing_non_preview_lesson(): void
    {
        $course = Course::factory()->create();
        $lesson = Lesson::factory()->create([
            'course_id' => $course->id,
            'is_preview' => false,
        ]);

        $response = $this->get(route('courses.lessons.show', [$course->slug, $lesson->id]));

        $response->assertForbidden();
    }

    #[Test]
    public function it_allows_enrolled_user_to_view_non_preview_lesson(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $lesson = Lesson::factory()->create([
            'course_id' => $course->id,
            'is_preview' => false,
        ]);

        // Enroll user in course
        $course->students()->attach($user->id);

        $response = $this->actingAs($user)
            ->get(route('courses.lessons.show', [$course->slug, $lesson->id]));

        $response->assertOk();
    }

    #[Test]
    public function it_denies_non_enrolled_user_from_viewing_non_preview_lesson(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $lesson = Lesson::factory()->create([
            'course_id' => $course->id,
            'is_preview' => false,
        ]);

        $response = $this->actingAs($user)
            ->get(route('courses.lessons.show', [$course->slug, $lesson->id]));

        $response->assertForbidden();
    }
}

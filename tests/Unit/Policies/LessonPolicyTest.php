<?php

declare(strict_types=1);

namespace Tests\Unit\Policies;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Policies\LessonPolicy;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LessonPolicyTest extends TestCase
{
    use RefreshDatabase;

    private LessonPolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new LessonPolicy;
    }

    #[Test]
    public function it_allows_lesson_from_correct_course(): void
    {
        $course = Course::factory()->create();
        $lesson = Lesson::factory()->create([
            'course_id' => $course->id,
            'is_preview' => true,
        ]);

        $result = $this->policy->view(null, $lesson);

        $this->assertTrue($result);
    }

    #[Test]
    public function it_allows_guest_for_preview_lesson(): void
    {
        $course = Course::factory()->create();
        $lesson = Lesson::factory()->create([
            'course_id' => $course->id,
            'is_preview' => true,
        ]);

        $result = $this->policy->view(null, $lesson);

        $this->assertTrue($result);
    }

    #[Test]
    public function it_denies_guest_access_to_non_preview_lesson(): void
    {
        $course = Course::factory()->create();
        $lesson = Lesson::factory()->create([
            'course_id' => $course->id,
            'is_preview' => false,
        ]);

        $result = $this->policy->view(null, $lesson);

        $this->assertFalse($result);
    }

    #[Test]
    public function it_allows_enrolled_user_for_non_preview(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $lesson = Lesson::factory()->create([
            'course_id' => $course->id,
            'is_preview' => false,
        ]);

        // Enroll user in course
        $course->students()->attach($user->id);

        $result = $this->policy->view($user, $lesson);

        $this->assertTrue($result);
    }

    #[Test]
    public function it_denies_non_enrolled_user_for_non_preview(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $lesson = Lesson::factory()->create([
            'course_id' => $course->id,
            'is_preview' => false,
        ]);

        $result = $this->policy->view($user, $lesson);

        $this->assertFalse($result);
    }
}

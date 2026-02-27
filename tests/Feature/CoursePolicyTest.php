<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Enums\StatusEnum;
use App\Policies\CoursePolicy;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CoursePolicyTest extends TestCase
{
    use RefreshDatabase;

    private CoursePolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new CoursePolicy;
    }

    #[Test]
    public function it_allows_verified_user_to_enroll_in_active_course(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $course = Course::factory()->create(['status' => StatusEnum::ACTIVE]);

        $result = $this->policy->enroll($user, $course);

        $this->assertTrue($result);
    }

    #[Test]
    public function it_denies_unverified_user_from_enrolling_in_active_course(): void
    {
        $user = User::factory()->create(['email_verified_at' => null]);
        $course = Course::factory()->create(['status' => StatusEnum::ACTIVE]);

        $result = $this->policy->enroll($user, $course);

        $this->assertFalse($result);
    }

    #[Test]
    public function it_denies_user_from_enrolling_in_inactive_course(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $course = Course::factory()->create(['status' => StatusEnum::INACTIVE]);

        $result = $this->policy->enroll($user, $course);

        $this->assertFalse($result);
    }

    #[Test]
    public function it_denies_already_enrolled_user_from_enrolling_again(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $course = Course::factory()->create(['status' => StatusEnum::ACTIVE]);

        // Enroll user in course
        $course->students()->attach($user->id);

        $result = $this->policy->enroll($user, $course);

        $this->assertFalse($result);
    }

    #[Test]
    public function it_denies_guest_from_enrolling_in_course(): void
    {
        $course = Course::factory()->create(['status' => StatusEnum::ACTIVE]);

        $result = $this->policy->enroll(null, $course);

        $this->assertFalse($result);
    }

    #[Test]
    public function it_allows_enrolled_user_to_unenroll_from_course(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();

        // Enroll user in course
        $course->students()->attach($user->id);

        $result = $this->policy->unenroll($user, $course);

        $this->assertTrue($result);
    }

    #[Test]
    public function it_denies_non_enrolled_user_from_unenrolling_from_course(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();

        $result = $this->policy->unenroll($user, $course);

        $this->assertFalse($result);
    }

    #[Test]
    public function it_denies_guest_from_unenrolling_from_course(): void
    {
        $course = Course::factory()->create();

        $result = $this->policy->unenroll(null, $course);

        $this->assertFalse($result);
    }

    #[Test]
    public function it_handles_course_viewing_with_guest_access(): void
    {
        $course = Course::factory()->create(['status' => StatusEnum::ACTIVE]);

        $response = $this->get(route('courses.show', $course));

        $response->assertOk();
    }

    #[Test]
    public function it_handles_lesson_viewing_with_policy_enforcement(): void
    {
        $course = Course::factory()->create(['status' => StatusEnum::ACTIVE]);
        $lesson = \App\Models\Lesson::factory()->create([
            'course_id' => $course->id,
            'is_preview' => true,
        ]);

        $response = $this->get(route('courses.lessons.show', [$course->slug, $lesson->id]));

        $response->assertOk();
    }
}

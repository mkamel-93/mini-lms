<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use Livewire\Livewire;
use App\Enums\StatusEnum;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Livewire\Course\Sections\CourseEnrollmentSection;

class CourseEnrollmentSectionTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_allows_authenticated_user_to_enroll_in_course(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $course = Course::factory()->create(['status' => StatusEnum::ACTIVE]);

        Livewire::actingAs($user)
            ->test(CourseEnrollmentSection::class, ['course' => $course])
            ->call('enroll')
            ->assertDispatched('enrolled');

        $this->assertDatabaseHas('enrollments', [
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);
    }

    #[Test]
    public function it_dispatches_enrollment_failed_when_course_is_null(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);

        Livewire::actingAs($user)
            ->test(CourseEnrollmentSection::class, ['course' => null])
            ->call('enroll')
            ->assertDispatched('enrollment-failed');
    }

    #[Test]
    public function it_allows_enrolled_user_to_unenroll_from_course(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();

        // Enroll user in course
        $course->students()->attach($user->id);

        Livewire::actingAs($user)
            ->test(CourseEnrollmentSection::class, ['course' => $course])
            ->call('unenroll')
            ->assertDispatched('unenrolled');

        $this->assertDatabaseMissing('enrollments', [
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);
    }

    #[Test]
    public function it_does_nothing_when_unenrolling_with_null_course(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(CourseEnrollmentSection::class, ['course' => null])
            ->call('unenroll')
            ->assertOk();
    }

    #[Test]
    public function it_correctly_computes_enrollment_status_for_authenticated_user(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create(['status' => StatusEnum::ACTIVE]);

        // Enroll user in course
        $course->students()->attach($user->id);

        Livewire::actingAs($user)
            ->test(CourseEnrollmentSection::class, ['course' => $course])
            ->assertSet('isEnrolled', true);
    }

    #[Test]
    public function it_returns_false_for_enrollment_status_when_guest(): void
    {
        $course = Course::factory()->create();

        Livewire::test(CourseEnrollmentSection::class, ['course' => $course])
            ->assertSet('isEnrolled', false);
    }

    #[Test]
    public function it_returns_false_for_enrollment_status_when_course_is_null(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(CourseEnrollmentSection::class, ['course' => null])
            ->assertSet('isEnrolled', false);
    }

    #[Test]
    public function it_responds_to_trigger_enroll_event(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $course = Course::factory()->create(['status' => StatusEnum::ACTIVE]);

        Livewire::actingAs($user)
            ->test(CourseEnrollmentSection::class, ['course' => $course])
            ->dispatch('trigger-enroll')
            ->assertDispatched('enrolled');
    }

    #[Test]
    public function it_throttles_enrollment_attempts(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $course = Course::factory()->create(['status' => StatusEnum::ACTIVE]);

        $component = Livewire::actingAs($user)
            ->test(CourseEnrollmentSection::class, ['course' => $course]);

        // First enrollment should succeed
        $component->call('enroll')->assertDispatched('enrolled');

        // Unenroll first
        $course->students()->detach($user->id);

        // Second immediate enrollment should be throttled
        $component->call('enroll')->assertDispatched('enrollment-failed');
    }

    #[Test]
    public function it_throttles_unenrollment_attempts(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();

        // Enroll user in course
        $course->students()->attach($user->id);

        $component = Livewire::actingAs($user)
            ->test(CourseEnrollmentSection::class, ['course' => $course]);

        // First unenrollment should succeed
        $component->call('unenroll')->assertDispatched('unenrolled');

        // Enroll again
        $course->students()->attach($user->id);

        // Second immediate unenrollment should be throttled (no event dispatched)
        $component->call('unenroll')->assertOk();
    }
}

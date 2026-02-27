<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Enums\StatusEnum;
use App\Models\Enrollment;
use InvalidArgumentException;
use App\Services\EnrollmentService;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EnrollmentServiceTest extends TestCase
{
    use RefreshDatabase;

    private EnrollmentService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(EnrollmentService::class);
    }

    #[Test]
    public function it_creates_enrollment_record_in_database(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create(['status' => StatusEnum::ACTIVE]);

        $this->actingAs($user);

        $this->service->enroll($course);

        $this->assertDatabaseHas('enrollments', [
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);
    }

    #[Test]
    public function it_deletes_enrollment_record_from_database(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create(['status' => StatusEnum::ACTIVE]);

        $this->actingAs($user);

        // Enroll user
        $this->service->enroll($course);

        // Unenroll user
        $this->service->unenroll($course);

        $this->assertDatabaseMissing('enrollments', [
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);
    }

    #[Test]
    public function it_respects_unique_constraint_on_enrollments(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create(['status' => StatusEnum::ACTIVE]);

        $this->actingAs($user);

        // Enroll multiple times
        $this->service->enroll($course);
        $this->service->enroll($course);
        $this->service->enroll($course);

        // Should only have one enrollment record
        $this->assertEquals(1, $user->enrollments()->count());
    }

    #[Test]
    public function it_handles_concurrent_enrollment_attempts(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create(['status' => StatusEnum::ACTIVE]);

        $this->actingAs($user);

        // Simulate concurrent enrollments
        $enrollment1 = $this->service->enroll($course);
        $enrollment2 = $this->service->enroll($course);

        $this->assertEquals($enrollment1->id, $enrollment2->id);
        $this->assertEquals(1, $user->enrollments()->count());
    }

    #[Test]
    public function it_rejects_enrollment_for_inactive_courses(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create(['status' => StatusEnum::INACTIVE]);

        $this->actingAs($user);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Course is not active for enrollment.');

        $this->service->enroll($course);  // called after exception because transaction
    }

    #[Test]
    public function it_requires_authenticated_user_for_enrollment(): void
    {
        $course = Course::factory()->create(['status' => StatusEnum::ACTIVE]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('User must be authenticated to enroll.');

        $this->service->enroll($course);  // called after exception because transaction
    }

    #[Test]
    public function it_requires_authenticated_user_for_unenrollment(): void
    {
        $course = Course::factory()->create(['status' => StatusEnum::ACTIVE]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('User must be authenticated to unenroll.');

        $this->service->unenroll($course); // called after exception because transaction
    }

    #[Test]
    public function it_returns_false_when_unenrolling_non_existent_enrollment(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create(['status' => StatusEnum::ACTIVE]);

        $this->actingAs($user);

        $result = $this->service->unenroll($course);

        $this->assertFalse($result);
    }

    #[Test]
    public function it_handles_database_transaction_rollback_on_failure(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create(['status' => StatusEnum::INACTIVE]);

        $this->actingAs($user);

        $initialEnrollmentCount = Enrollment::count();

        try {
            $this->service->enroll($course);
        } catch (InvalidArgumentException $e) {
            // Expected exception
        }

        // Ensure no enrollment was created due to transaction rollback
        $this->assertEquals($initialEnrollmentCount, Enrollment::count());
    }

    #[Test]
    public function it_checks_enrollment_status_correctly(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create(['status' => StatusEnum::ACTIVE]);

        $this->actingAs($user);

        // Initially not enrolled
        $this->assertFalse($this->service->isEnrolled($course));

        // Enroll user
        $this->service->enroll($course);

        // Now enrolled
        $this->assertTrue($this->service->isEnrolled($course));
    }

    #[Test]
    public function it_returns_false_for_enrollment_check_without_auth(): void
    {
        $course = Course::factory()->create(['status' => StatusEnum::ACTIVE]);

        // No authentication
        $this->assertFalse($this->service->isEnrolled($course));
    }
}

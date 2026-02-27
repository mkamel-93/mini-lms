<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Course;
use App\Enums\StatusEnum;
use App\Models\Enrollment;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;

class EnrollmentService
{
    public function enroll(Course $course): Enrollment
    {
        return DB::transaction(function () use ($course) {
            $user = auth()->user();
            if ($user === null) {
                throw new InvalidArgumentException('User must be authenticated to enroll.');
            }

            $this->validateEnrollment($course);

            return Enrollment::firstOrCreate([
                'user_id' => $user->id,
                'course_id' => $course->id,
            ]);
        });
    }

    public function unenroll(Course $course): bool
    {
        return DB::transaction(function () use ($course) {
            $user = auth()->user();
            if ($user === null) {
                throw new InvalidArgumentException('User must be authenticated to unenroll.');
            }

            $enrollment = Enrollment::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->first();

            if ($enrollment === null) {
                return false;
            }

            return $enrollment->delete();
        }) ?? false;
    }

    public function isEnrolled(Course $course): bool
    {
        $user = auth()->user();
        if ($user === null) {
            return false;
        }

        // Check if a relation is already loaded to avoid a duplicate query
        if ($course->relationLoaded('students')) {
            return $course->students->contains('id', $user->id);
        }

        return $course->students()
            ->where('user_id', $user->id)
            ->exists();
    }

    private function validateEnrollment(Course $course): void
    {
        if ($course->status !== StatusEnum::ACTIVE) {
            throw new InvalidArgumentException('Course is not active for enrollment.');
        }
    }
}

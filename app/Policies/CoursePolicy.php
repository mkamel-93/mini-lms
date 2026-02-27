<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use App\Models\Course;
use App\Enums\StatusEnum;

class CoursePolicy
{
    /**
     * Determine if the user can enroll in the course.
     */
    public function enroll(?User $user, Course $course): bool
    {
        if ($user === null) {
            return false;
        }

        // Check if user is already enrolled using the relationship
        $isAlreadyEnrolled = $user->courses()->where('course_id', $course->id)->exists();

        return $user->hasVerifiedEmail()
            && $course->status === StatusEnum::ACTIVE
            && ! $isAlreadyEnrolled;
    }

    /**
     * Determine if the user can unenroll from the course.
     */
    public function unenroll(?User $user, Course $course): bool
    {
        if ($user === null) {
            return false;
        }

        return $user->courses()->where('course_id', $course->id)->exists();
    }
}

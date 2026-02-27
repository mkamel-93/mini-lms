<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;

class LessonPolicy
{
    /**
     * Determine if the user can view the lesson.
     */
    public function view(?User $user, Lesson $lesson): bool
    {
        // If it's a preview lesson, everyone (guest or auth) can see it
        if ($lesson->is_preview) {
            return true;
        }

        // If it's not a preview, the user MUST be logged in
        if (! $user) {
            return false;
        }

        // The user must be enrolled in the course to see non-preview lessons
        return $user->courses()
            ->where('course_id', $lesson->course_id)
            ->exists();
    }
}

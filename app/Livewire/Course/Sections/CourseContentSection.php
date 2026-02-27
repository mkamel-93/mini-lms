<?php

declare(strict_types=1);

namespace App\Livewire\Course\Sections;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\View\View;
use App\Core\BaseComponent;
use Livewire\Attributes\Reactive;
use App\Services\EnrollmentService;

class CourseContentSection extends BaseComponent
{
    #[Reactive]
    public ?Course $course = null;

    protected ?bool $isEnrolled = null;

    public function triggerEnroll(): void
    {
        $this->dispatch('trigger-enroll');
    }

    /**
     * Get the label and URL for a specific lesson button.
     *
     * @return array{label: string, url: string, is_enroll_action: bool}
     */
    public function getLessonAction(Lesson $lesson): array
    {
        if ($this->course === null) {
            return [
                'url' => '#',
                'label' => '-',
                'is_enroll_action' => false,
            ];
        }

        $user = auth()->user();

        // If it's a free preview, allow direct navigation regardless of auth status
        if ($lesson->is_preview) {
            return [
                'label' => __('Preview'),
                'url' => route('courses.lessons.show', [$this->course->slug, $lesson->id]),
                'is_enroll_action' => false,
            ];
        }

        if (! $user) {
            return [
                'label' => __('Login to Start'),
                'url' => route('login'),
                'is_enroll_action' => false,
            ];
        }

        // If enrolled, allow direct navigation
        if ($this->isEnrolled) {
            return [
                'label' => __('Continue Lesson'),
                'url' => route('courses.lessons.show', [$this->course->slug, $lesson->id]),
                'is_enroll_action' => false,
            ];
        }

        // Logged in but not enrolled: Trigger enrollment action instead of navigation
        return [
            'label' => __('Enroll to Start'),
            'url' => '#',
            'is_enroll_action' => true,
        ];
    }

    public function render(): View
    {
        if ($this->course !== null && $this->isEnrolled === null) {
            $this->isEnrolled = app(EnrollmentService::class)->isEnrolled($this->course);
        }

        return view('livewire.course.sections.course-content-section');
    }
}

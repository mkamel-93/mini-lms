<?php

declare(strict_types=1);

namespace App\Livewire\Course\Sections;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\View\View;
use App\Core\BaseComponent;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Reactive;
use App\Services\EnrollmentService;

class CourseContentSection extends BaseComponent
{
    #[Locked]
    #[Reactive]
    public ?Course $course = null;

    public function mount(Course $course): void
    {
        $this->course = $course;
    }

    /**
     * @return array{url: string, label: string}
     */
    public function getLessonActionData(Lesson $lesson): array
    {
        if ($this->course === null) {
            return [
                'url' => '#',
                'label' => '-',
            ];
        }

        $loggedUser = auth()->check();
        $canStart = $loggedUser || $lesson->is_preview;

        $label = match (true) {
            ! $canStart => __('Login to Start'),
            $lesson->is_preview || (app(EnrollmentService::class)->isEnrolled($this->course)) => __('Start'),
            default => __('Enroll To Watch'),
        };

        return [
            'url' => $canStart
                ? route('courses.lessons.show', [$this->course->slug, $lesson->id])
                : route('login'),
            'label' => $label,
        ];
    }

    public function render(): View
    {
        return view('livewire.course.sections.course-content-section');
    }
}

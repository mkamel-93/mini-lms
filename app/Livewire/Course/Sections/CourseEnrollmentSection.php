<?php

declare(strict_types=1);

namespace App\Livewire\Course\Sections;

use App\Models\Course;
use Illuminate\View\View;
use App\Core\BaseComponent;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Reactive;
use App\Services\EnrollmentService;

class CourseEnrollmentSection extends BaseComponent
{
    #[Locked]
    #[Reactive]
    public ?Course $course = null;

    public function mount(Course $course): void
    {
        $this->course = $course;
    }

    public function enroll(EnrollmentService $service): void
    {
        if ($this->course === null) {
            return;
        }

        if ($this->isThrottled(action: "enroll-{$this->course->id}")) {
            return;
        }

        $this->authorize('enroll', $this->course);

        $service->enroll($this->course);

        $this->dispatch('enrolled');
    }

    public function unenroll(EnrollmentService $service): void
    {
        if ($this->course === null) {
            return;
        }

        if ($this->isThrottled(action: "unenroll-{$this->course->id}")) {
            return;
        }

        $this->authorize('unenroll', $this->course);

        $service->unenroll($this->course);

        $this->dispatch('unenrolled');
    }

    #[Computed]
    public function isEnrolled(): bool
    {
        if (! auth()->check() || $this->course === null) {
            return false;
        }

        // 3. For Computed properties, use app() resolve or injection
        return app(EnrollmentService::class)->isEnrolled($this->course);
    }

    public function render(): View
    {
        return view('livewire.course.sections.course-enrollment-section');
    }
}

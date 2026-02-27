<?php

declare(strict_types=1);

namespace App\Livewire\Course\Sections;

use Exception;
use App\Models\Course;
use Illuminate\View\View;
use App\Core\BaseComponent;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Reactive;
use App\Services\EnrollmentService;

class CourseEnrollmentSection extends BaseComponent
{
    #[Reactive]
    public ?Course $course = null;

    #[On('trigger-enroll')]
    public function enroll(EnrollmentService $service): void
    {
        if ($this->course === null) {
            $this->dispatch('enrollment-failed');

            return;
        }

        if ($this->isThrottled(action: "enroll-{$this->course->id}")) {
            $this->dispatch('enrollment-failed');

            return;
        }

        try {
            $this->authorize('enroll', $this->course);

            $service->enroll($this->course);

            $this->dispatch('enrolled');
        } catch (Exception $e) {
            $this->dispatch('enrollment-failed');
            logger()->error($e->getMessage());
        }
    }

    public function unenroll(EnrollmentService $service): void
    {
        if ($this->course === null) {
            return;
        }

        if ($this->isThrottled(action: "unenroll-{$this->course->id}")) {
            return;
        }
        try {
            $this->authorize('unenroll', $this->course);

            $service->unenroll($this->course);

            $this->dispatch('unenrolled');
        } catch (Exception $e) {
            $this->dispatch('enrollment-failed');
            logger()->error($e->getMessage());
        }
    }

    #[Computed]
    public function isEnrolled(): bool
    {
        if (! auth()->check() || $this->course === null) {
            return false;
        }

        return app(EnrollmentService::class)->isEnrolled($this->course);
    }

    public function render(): View
    {
        return view('livewire.course.sections.course-enrollment-section');
    }
}

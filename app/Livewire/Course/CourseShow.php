<?php

declare(strict_types=1);

namespace App\Livewire\Course;

use App\Models\Course;
use Illuminate\View\View;
use App\Core\BaseComponent;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Course / Show')]
#[Layout('layouts.guest')]
class CourseShow extends BaseComponent
{
    public ?Course $course = null;

    public function mount(Course $course): void
    {
        $this->loadCourse($course);
    }

    #[On(['enrolled', 'unenrolled'])]
    public function refreshCourse(): void
    {
        if ($this->course?->slug) {
            $this->loadCourse($this->course);
        }
    }

    private function loadCourse(Course $course): void
    {
        $this->course = Course::with(['lessons'])
            ->with(['students' => fn ($q) => $q->where('user_id', auth()->id())])
            ->withCount(['lessons', 'students'])
            ->where('slug', $course->slug)
            ->active()
            ->firstOrFail();
    }

    public function render(): View
    {
        return view('livewire.course.show');
    }
}

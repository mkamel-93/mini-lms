<?php

declare(strict_types=1);

namespace App\Livewire\Course\Lesson;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\View\View;
use App\Core\BaseComponent;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Lesson / Show')]
#[Layout('layouts.guest')]
class LessonShow extends BaseComponent
{
    public ?Course $course = null;

    public ?Lesson $lesson = null;

    /** @var array<string, mixed> */
    public array $lessons = [];

    public function mount(Course $course, Lesson $lesson): void
    {
        $this->authorize('view', $lesson);

        $this->course = $course->load(['lessons' => fn ($query) => $query->active()->orderBy('order')]);

        $this->lesson = $lesson;
        $this->lessons = $this->course->lessons->toArray();
    }

    public function render(): View
    {
        return view('livewire.course.lesson.lesson-show');
    }
}

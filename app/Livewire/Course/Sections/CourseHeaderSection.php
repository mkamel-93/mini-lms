<?php

declare(strict_types=1);

namespace App\Livewire\Course\Sections;

use App\Models\Course;
use Illuminate\View\View;
use App\Core\BaseComponent;
use Livewire\Attributes\Reactive;

class CourseHeaderSection extends BaseComponent
{
    #[Reactive]
    public ?Course $course = null;

    public function render(): View
    {
        return view('livewire.course.sections.course-header-section');
    }
}

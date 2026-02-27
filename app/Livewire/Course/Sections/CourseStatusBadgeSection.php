<?php

declare(strict_types=1);

namespace App\Livewire\Course\Sections;

use App\Models\Course;
use App\Enums\StatusEnum;
use Illuminate\View\View;
use App\Core\BaseComponent;

class CourseStatusBadgeSection extends BaseComponent
{
    public ?Course $course = null;

    public function mount(Course $course): void
    {
        $this->course = $course;
    }

    public function getBadgeClasses(): string
    {
        $baseClasses = 'inline-flex items-center rounded-full font-medium';

        $sizeClasses = 'px-3 py-1 text-sm';

        $colorClasses = match ($this->course?->status->value) {
            StatusEnum::ACTIVE->value => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            StatusEnum::INACTIVE->value => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200'
        };

        return $baseClasses.' '.$sizeClasses.' '.$colorClasses;
    }

    public function render(): View
    {
        return view('livewire.course.sections.course-status-badge-section');
    }
}

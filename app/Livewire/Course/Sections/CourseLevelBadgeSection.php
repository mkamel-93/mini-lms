<?php

declare(strict_types=1);

namespace App\Livewire\Course\Sections;

use App\Models\Course;
use Illuminate\View\View;
use App\Core\BaseComponent;
use Livewire\Attributes\Reactive;

class CourseLevelBadgeSection extends BaseComponent
{
    #[Reactive]
    public ?Course $course = null;

    public function getBadgeClasses(): string
    {
        $baseClasses = 'inline-flex items-center rounded-full font-medium';

        $sizeClasses = 'px-3 py-1 text-sm';

        $colorClasses = match ($this->course?->level->value) {
            'beginner' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            'intermediate' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
            'advanced' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200'
        };

        return $baseClasses.' '.$sizeClasses.' '.$colorClasses;
    }

    public function render(): View
    {
        return view('livewire.course.sections.course-level-badge-section');
    }
}

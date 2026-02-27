<?php

declare(strict_types=1);

namespace App\Livewire\Course;

use App\Models\Course;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Core\BaseManagementPaginationComponent;
use Illuminate\Pagination\LengthAwarePaginator;

#[Title('Courses / Index')]
#[Layout('layouts.guest')]
class CourseIndex extends BaseManagementPaginationComponent
{
    /**
     * Get paginated list
     *
     * @return LengthAwarePaginator<array-key, Course>
     */
    #[Computed]
    public function data(): LengthAwarePaginator
    {
        $query = Course::active()->withCount(['lessons', 'students']);

        // If user is authenticated, add enrollment status
        if (auth()->check()) {
            $query->withExists([
                'students as is_enrolled' => function ($query) {
                    $query->where('user_id', auth()->id());
                },
            ]);
        }

        return $query->paginate($this->perPage);
    }

    public function render(): View
    {
        return view('livewire.course.index');
    }
}

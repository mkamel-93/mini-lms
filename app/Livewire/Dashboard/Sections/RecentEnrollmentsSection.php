<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Sections;

use App\Models\User;
use Illuminate\View\View;
use App\Models\Enrollment;
use Livewire\Attributes\Computed;
use App\Core\BaseManagementPaginationComponent;
use Illuminate\Pagination\LengthAwarePaginator;

class RecentEnrollmentsSection extends BaseManagementPaginationComponent
{
    public ?User $user = null;

    public function mount(User $user): void
    {
        $this->user = $user;
    }

    /**
     * Get paginated list
     *
     * @return LengthAwarePaginator<array-key, Enrollment>
     */
    #[Computed]
    public function data(): LengthAwarePaginator
    {
        return $this->user?->enrollments()
            ->with(['course:id,title'])
            ->paginate(perPage: $this->perPage, pageName: 'enrollments_page')
            ?? new LengthAwarePaginator([], 0, $this->perPage);
    }

    /**
     * Get enrollment statistics
     *
     * @return array<string, int>
     */
    #[Computed]
    public function stats(): array
    {
        /** @phpstan-ignore property.notFound */
        $data = $this->data;

        return [
            'total_enrollments' => $data->total(),
        ];
    }

    /**
     * Render the component
     */
    public function render(): View
    {
        return view('livewire.dashboard.sections.recent-enrollments-section');
    }
}

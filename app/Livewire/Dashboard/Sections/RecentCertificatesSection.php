<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Sections;

use App\Models\User;
use Illuminate\View\View;
use App\Models\Certificate;
use Livewire\Attributes\Computed;
use App\Core\BaseManagementPaginationComponent;
use Illuminate\Pagination\LengthAwarePaginator;

class RecentCertificatesSection extends BaseManagementPaginationComponent
{
    public ?User $user = null;

    public function mount(User $user): void
    {
        $this->user = $user;
    }

    /**
     * Get paginated list
     *
     * @return LengthAwarePaginator<array-key, Certificate>
     */
    #[Computed]
    public function data(): LengthAwarePaginator
    {
        return $this->user?->certificates()
            ->with(['course:id,title,slug'])
            ->paginate(perPage: $this->perPage, pageName: 'certificates_page')
            ?? new LengthAwarePaginator([], 0, $this->perPage);
    }

    /**
     * Get certificate statistics
     *
     * @return array<string, int>
     */
    #[Computed]
    public function stats(): array
    {
        /** @phpstan-ignore property.notFound */
        $data = $this->data;

        return [
            'total_certificates' => $data->total(),
        ];
    }

    /**
     * Render the component
     */
    public function render(): View
    {
        return view('livewire.dashboard.sections.recent-certificates-section');
    }
}

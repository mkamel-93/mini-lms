<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Sections;

use App\Models\User;
use Livewire\Component;
use Illuminate\View\View;
use App\Core\BaseComponent;

class ProfileSummarySection extends BaseComponent
{
    public ?User $user = null;

    public function mount(User $user): void
    {
        $this->user = $user;
    }

    /**
     * Render the component
     */
    public function render(): View
    {
        return view('livewire.dashboard.sections.profile-summary-section');
    }
}

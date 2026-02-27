<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard;

use App\Models\User;
use Illuminate\View\View;
use App\Core\BaseComponent;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Dashboard')]
#[Layout('layouts.app')]
class Index extends BaseComponent
{
    public ?User $user = null;

    public function mount(): void
    {
        $user = auth()->user();
        if ($user === null) {
            return;
        }
        $this->user = $user;
    }

    /**
     * Render the component
     */
    public function render(): View
    {
        return view('livewire.dashboard.index');
    }
}

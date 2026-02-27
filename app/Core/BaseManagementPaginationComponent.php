<?php

declare(strict_types=1);

namespace App\Core;

use Livewire\WithPagination;

class BaseManagementPaginationComponent extends BaseComponent
{
    use WithPagination;

    public int $perPage = 6;
}

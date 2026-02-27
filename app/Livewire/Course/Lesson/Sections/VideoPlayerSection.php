<?php

declare(strict_types=1);

namespace App\Livewire\Course\Lesson\Sections;

use App\Models\Lesson;
use Illuminate\View\View;
use App\Core\BaseComponent;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Video / Show')]
#[Layout('layouts.guest')]
class VideoPlayerSection extends BaseComponent
{
    public ?Lesson $lesson = null;

    public function mount(Lesson $lesson): void
    {
        $this->lesson = $lesson;
    }

    public function render(): View
    {
        return view('livewire.course.lesson.sections.video-player-section');
    }
}

<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire;

use Tests\TestCase;
use App\Models\Course;
use Livewire\Livewire;
use App\Enums\StatusEnum;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Livewire\Course\Sections\CourseStatusBadgeSection;

class CourseStatusBadgeSectionTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_renders_successfully_with_course(): void
    {
        $course = Course::factory()->create();

        Livewire::test(CourseStatusBadgeSection::class, ['course' => $course])
            ->assertOk();
    }

    #[Test]
    public function it_returns_correct_classes_for_active_status(): void
    {
        $course = Course::factory()->create(['status' => StatusEnum::ACTIVE]);

        Livewire::test(CourseStatusBadgeSection::class, ['course' => $course])
            ->assertSee('bg-green-100')
            ->assertSee('text-green-800');
    }

    #[Test]
    public function it_returns_correct_classes_for_inactive_status(): void
    {
        $course = Course::factory()->create(['status' => StatusEnum::INACTIVE]);

        Livewire::test(CourseStatusBadgeSection::class, ['course' => $course])
            ->assertSee('bg-red-100')
            ->assertSee('text-red-800');
    }

    #[Test]
    public function it_includes_base_and_size_classes(): void
    {
        $course = Course::factory()->create();

        Livewire::test(CourseStatusBadgeSection::class, ['course' => $course])
            ->assertSee('inline-flex')
            ->assertSee('items-center')
            ->assertSee('rounded-full')
            ->assertSee('px-3')
            ->assertSee('py-1');
    }
}

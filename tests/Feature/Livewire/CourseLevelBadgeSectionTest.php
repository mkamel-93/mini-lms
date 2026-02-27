<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire;

use Tests\TestCase;
use App\Models\Course;
use Livewire\Livewire;
use App\Enums\CourseLevelEnum;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Livewire\Course\Sections\CourseLevelBadgeSection;

class CourseLevelBadgeSectionTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_renders_successfully_with_course(): void
    {
        $course = Course::factory()->create(['level' => CourseLevelEnum::BEGINNER]);

        Livewire::test(CourseLevelBadgeSection::class, ['course' => $course])
            ->assertOk();
    }

    #[Test]
    public function it_returns_correct_classes_for_beginner_level(): void
    {
        $course = Course::factory()->create(['level' => CourseLevelEnum::BEGINNER]);

        Livewire::test(CourseLevelBadgeSection::class, ['course' => $course])
            ->assertSee('bg-green-100');
    }

    #[Test]
    public function it_returns_correct_classes_for_intermediate_level(): void
    {
        $course = Course::factory()->create(['level' => CourseLevelEnum::INTERMEDIATE]);

        Livewire::test(CourseLevelBadgeSection::class, ['course' => $course])
            ->assertSee('bg-yellow-100');
    }

    #[Test]
    public function it_returns_correct_classes_for_advanced_level(): void
    {
        $course = Course::factory()->create(['level' => CourseLevelEnum::ADVANCED]);

        Livewire::test(CourseLevelBadgeSection::class, ['course' => $course])
            ->assertSee('bg-red-100');
    }
}

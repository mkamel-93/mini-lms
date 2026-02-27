<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire;

use Tests\TestCase;
use App\Models\Course;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Livewire\Course\Sections\CourseHeaderSection;

class CourseHeaderSectionTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_renders_successfully_with_course(): void
    {
        $course = Course::factory()->create();

        Livewire::test(CourseHeaderSection::class, ['course' => $course])
            ->assertOk()
            ->assertSet('course.id', $course->id);
    }

    #[Test]
    public function it_renders_successfully_with_null_course(): void
    {
        Livewire::test(CourseHeaderSection::class, ['course' => null])
            ->assertOk();
    }
}

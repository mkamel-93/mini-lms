<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Lesson;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use App\Livewire\Course\Lesson\LessonShow;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Livewire\Course\Lesson\Sections\VideoPlayerSection;

class LessonShowComponentTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_renders_lesson_show_page_for_preview_lesson(): void
    {
        $course = Course::factory()->create();
        $lesson = Lesson::factory()->create([
            'course_id' => $course->id,
            'is_preview' => true,
        ]);

        Livewire::test(LessonShow::class, [
            'course' => $course,
            'lesson' => $lesson,
        ])
            ->assertOk()
            ->assertSet('course.id', $course->id)
            ->assertSet('lesson.id', $lesson->id);
    }

    #[Test]
    public function it_loads_course_with_active_lessons_ordered_by_order(): void
    {
        $course = Course::factory()->create();
        $lesson1 = Lesson::factory()->create([
            'course_id' => $course->id,
            'is_preview' => true,
            'status' => \App\Enums\StatusEnum::ACTIVE,
            'order' => 2,
        ]);
        $lesson2 = Lesson::factory()->create([
            'course_id' => $course->id,
            'is_preview' => true,
            'status' => \App\Enums\StatusEnum::ACTIVE,
            'order' => 1,
        ]);

        $component = Livewire::test(LessonShow::class, ['course' => $course, 'lesson' => $lesson1]);

        $this->assertEquals(2, $component->get('course.lessons')->count());
        $this->assertEquals($lesson2->id, $component->get('course.lessons')->first()->id);
    }

    #[Test]
    public function it_renders_successfully_with_lesson(): void
    {
        $lesson = Lesson::factory()->create([
            'video_url' => 'https://example.com/video.mp4',
        ]);

        Livewire::test(VideoPlayerSection::class, ['lesson' => $lesson])
            ->assertOk()
            ->assertSet('lesson.id', $lesson->id);
    }

    #[Test]
    public function it_mounts_with_lesson_data(): void
    {
        $lesson = Lesson::factory()->create([
            'video_url' => 'https://example.com/video.mp4',
        ]);

        $component = Livewire::test(VideoPlayerSection::class, ['lesson' => $lesson]);

        $this->assertEquals($lesson->id, $component->get('lesson')->id);
        $this->assertEquals($lesson->video_url, $component->get('lesson')->video_url);
    }
}

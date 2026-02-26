<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Enums\StatusEnum;
use App\Models\Enrollment;
use App\Models\Certificate;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::transaction(function () {
            // 1. Ensure test user exists
            $user = User::query()->firstOrCreate(
                ['email' => 'mostafa.kamel@mini-lms.com'],
                [
                    'name' => 'Mostafa Kamel',
                    'email_verified_at' => now(),
                    'password' => config('auth.default_password'),
                ]
            );

            // 2. Fetch data from config
            $realCourseData = config('courses-data.real_data', []);
            $realVideos = config('courses-data.video_urls', []);

            $activeCourses = collect();

            // 3. Loop through real data and create records
            foreach ($realCourseData as $data) {
                $course = Course::factory()->create([
                    'title' => $data['title'],
                    'slug' => Str::slug($data['title']),
                    'description' => $data['description'],
                    'level' => $data['level'],
                    'status' => StatusEnum::ACTIVE,
                ]);

                $lessonTitles = $data['lessons'];

                // Create lessons specifically for THIS course
                Lesson::factory()
                    ->count(count($lessonTitles))
                    ->sequence(fn ($lessonSeq) => [
                        'title' => $lessonTitles[$lessonSeq->index],
                        'order' => $lessonSeq->index + 1,
                        'is_preview' => $lessonSeq->index === 0,
                        'video_url' => $realVideos[array_rand($realVideos)],
                    ])
                    ->create([
                        'course_id' => $course->id,
                    ]);

                $activeCourses->push($course);
            }

            // 4. Setup Enrollments for the test user
            $enrolledCourses = $activeCourses->take(3);

            $enrolledCourses->each(function ($course) use ($user) {
                Enrollment::factory()->create([
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                ]);
            });

            // 5. Issue a Certificate for the first course
            if ($firstCourse = $enrolledCourses->first()) {
                Certificate::factory()->create([
                    'user_id' => $user->id,
                    'course_id' => $firstCourse->id,
                ]);
            }
        });
    }
}

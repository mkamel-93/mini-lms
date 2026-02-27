<!-- Course Header -->
<div class="mb-8">
    <a
        class="inline-flex items-center text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 mb-4"
        href="{{ route('home') }}"
        wire:navigate
    >
        <svg
            class="w-4 h-4 mr-2"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 19l-7-7 7-7"
            ></path>
        </svg>
        {{ __('Back to Courses') }}
    </a>
    @isset($course)
        <div class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow-sm p-8">
            <div class="flex items-start justify-between mb-6">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100 mb-4">
                        {{ $course->title }}
                    </h1>
                </div>
                <livewire:course.sections.course-status-badge-section
                    :course="$course"
                    :key="'course-status-' . $course->id"
                />
            </div>

            <!-- Course Stats -->
            <div class="flex items-center space-x-6 text-sm text-zinc-600 dark:text-zinc-400">
                <div class="flex items-center">
                    <svg
                        class="w-5 h-5 mr-2"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                        ></path>
                    </svg>
                    {{ $course->lessons_count }} {{ __('lessons') }}
                </div>

                <div class="flex items-center">
                    <svg
                        class="w-5 h-5 mr-2"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                        ></path>
                    </svg>
                    {{ $course->students_count }} {{ __('students enrolled') }}
                </div>

                <livewire:course.sections.course-level-badge-section
                    :course="$course"
                    :key="'course-level-' . $course->id"
                />
            </div>
        </div>
    @endisset
</div>

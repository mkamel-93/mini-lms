<div class="container mx-auto px-4 py-12">
    <!-- Breadcrumb -->
    <div class="mb-6">
        <nav class="flex items-center space-x-2 text-sm text-zinc-600 dark:text-zinc-400">
            <a
                class="hover:text-zinc-900 dark:hover:text-zinc-100"
                href="{{ route('home') }}"
                wire:navigate
            >
                {{ __('Courses') }}
            </a>
            <svg
                class="w-4 h-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 5l7 7-7 7"
                ></path>
            </svg>
            <a
                class="hover:text-zinc-900 dark:hover:text-zinc-100"
                href="{{ route('courses.show', $course->slug) }}"
                wire:navigate
            >
                {{ $course->title }}
            </a>
            <svg
                class="w-4 h-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 5l7 7-7 7"
                ></path>
            </svg>
            <span class="text-zinc-900 dark:text-zinc-100">{{ $lesson->title }}</span>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Video Player and Content -->
        <div class="lg:col-span-2">
            <!-- Video Player Section -->
            <livewire:course.lesson.sections.video-player-section :lesson="$lesson" />
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Course Info Card -->
            <div
                class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6 sticky top-6">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-4">
                    {{ __('Course') }}
                </h3>

                <div class="space-y-4">
                    <div>
                        <h4 class="font-medium text-zinc-900 dark:text-zinc-100 mb-1">
                            {{ $course->title }}
                        </h4>
                        <div class="flex items-center space-x-4 text-sm text-zinc-600 dark:text-zinc-400">
                            <livewire:course.sections.course-level-badge-section :course="$course" />
                        </div>
                    </div>

                    <div class="pt-4 border-t border-zinc-200 dark:border-zinc-700">
                        <a
                            class="block w-full px-4 py-2 text-center text-zinc-700 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-700 hover:bg-zinc-200 dark:hover:bg-zinc-600 rounded-lg transition-colors"
                            href="{{ route('courses.show', $course->slug) }}"
                            wire:navigate
                        >
                            {{ __('Back to Course') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

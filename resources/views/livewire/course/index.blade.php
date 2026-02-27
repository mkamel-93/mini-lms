<div class="container mx-auto px-4 py-12">
    <!-- Header Section -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-zinc-900 dark:text-zinc-100 mb-4">
            Welcome to {{ config('app.name') }}
        </h1>

        <p class="text-lg text-zinc-600 dark:text-zinc-400 mb-8 max-w-2xl mx-auto">
            Discover our comprehensive courses and start your learning journey today
        </p>

    </div>
    @if ($this->data->count() > 0)
        <!-- Courses Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100 mb-8">
                {{ __('Available Courses') }}
            </h2>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($this->data as $course)
                    <div
                        class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <div class="p-6">
                            <!-- Course Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                                            {{ $course->title }}
                                        </h3>

                                        @auth
                                            @if ($course->is_enrolled)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200"
                                                >
                                                    {{ __('Enrolled') }}
                                                </span>
                                            @endif
                                        @endauth
                                    </div>

                                    <!-- Course Level Badge -->
                                    <livewire:course.sections.course-level-badge-section
                                        :course="$course"
                                        :key="'course-level-' . $course->id"
                                    />
                                </div>
                            </div>

                            <!-- Course Stats -->
                            <div class="flex items-center space-x-4 text-sm text-zinc-600 dark:text-zinc-400 mb-4">
                                <div class="flex items-center">
                                    <svg
                                        class="w-4 h-4 mr-1"
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
                                        class="w-4 h-4 mr-1"
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
                                    {{ $course->students_count }} {{ __('students') }}
                                </div>
                            </div>

                            <!-- Course Actions -->
                            <div class="flex items-center justify-between">
                                <a
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300"
                                    href="{{ route('courses.show', $course->slug) }}"
                                    wire:navigate
                                >
                                    {{ __('View Course') }}
                                    <svg
                                        class="w-4 h-4 ml-1"
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
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($this->data instanceof \Illuminate\Contracts\Pagination\Paginator && $this->data->hasPages())
                <div class="mt-8">
                    <div class="rounded-lg bg-white px-4 py-3 shadow-sm sm:px-6 dark:bg-gray-800">
                        {{ $this->data->onEachSide(1)->links() }}
                    </div>
                </div>
            @endif
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="flex justify-center mb-4">
                <svg
                    class="w-16 h-16 text-zinc-400"
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
            </div>

            <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-2">
                {{ __('No courses available yet') }}
            </h3>

            <p class="text-zinc-600 dark:text-zinc-400 mb-6">
                {{ __('Check back later for new courses or contact an administrator.') }}
            </p>
        </div>
    @endif

</div>

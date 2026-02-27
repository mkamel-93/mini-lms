<!-- Lessons Section -->
<div class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow-sm p-6">
    <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100 mb-6">
        {{ __('Course Content') }}
    </h2>
    <p class="text-base text-zinc-600 dark:text-zinc-400 mb-6 leading-relaxed">
        {{ $course->description }}
    </p>
    @if ($course->lessons->count() > 0)
        <div class="space-y-3">
            @foreach ($course->lessons as $lesson)
                <div @class([
                    'flex items-center justify-between p-4 border rounded-lg transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-900',
                    // Default border colors
                    'border-zinc-200 dark:border-zinc-700' => !$lesson->is_preview,
                    // Green border for preview lessons
                    'border-emerald-500 dark:border-emerald-400 bg-emerald-50/30 dark:bg-emerald-900/10' =>
                        $lesson->is_preview,
                ])>
                    <div class="flex items-center">
                        <div @class([
                            'flex items-center justify-center w-8 h-8 rounded-full mr-4',
                            'bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400' => !$lesson->is_preview,
                            'bg-emerald-100 dark:bg-emerald-900 text-emerald-600 dark:text-emerald-400' =>
                                $lesson->is_preview,
                        ])>
                            {{ $loop->iteration }}
                        </div>
                        <div>
                            <h3 class="font-medium text-zinc-900 dark:text-zinc-100">
                                {{ $lesson->title ?? 'Lesson ' . $loop->iteration }}
                                @if ($lesson->is_preview)
                                    <span
                                        class="ml-2 text-xs font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400"
                                    >
                                        {{ __('Free To Watch') }}
                                    </span>
                                @endif
                            </h3>
                        </div>
                    </div>

                    @php($lessonAction = $this->getLessonActionData($lesson))

                    <a
                        href="{{ $lessonAction['url'] }}"
                        wire:navigate
                        @class([
                            'px-3 py-1 text-sm font-medium transition-colors',
                            'text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300' => !$lesson->is_preview,
                            'text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300' =>
                                $lesson->is_preview,
                        ])
                    >
                        {{ $lessonAction['label'] }}
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8">
            <svg
                class="w-12 h-12 text-zinc-400 mx-auto mb-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                ></path>
            </svg>
            <p class="text-zinc-600 dark:text-zinc-400">
                {{ __('No lessons available yet for this course.') }}
            </p>
        </div>
    @endif
</div>

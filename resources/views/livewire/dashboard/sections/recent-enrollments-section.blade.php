<div class="bg-white dark:bg-gray-800 rounded-xl border border-neutral-200 dark:border-neutral-700">
    <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Recent Enrollments</h2>
    </div>
    <div class="p-6">
        @if ($this->data->count() > 0)
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach ($this->stats as $key => $value)
                        <div
                            class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-neutral-200 dark:border-neutral-700">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ ucfirst($key) }}</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $value }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                @foreach ($this->data as $enrollment)
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="flex-1">
                            <h3 class="font-medium text-gray-900 dark:text-white">
                                {{ $enrollment->course?->title ?? __('Course unavailable') }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Enrolled on
                                {{ $enrollment->created_at->format('M d, Y') }}</p>
                        </div>
                        <div
                            class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-1 rounded-full text-sm">
                            Active
                        </div>
                    </div>
                @endforeach
                @if ($this->data instanceof \Illuminate\Contracts\Pagination\Paginator && $this->data->hasPages())
                    <div class="mt-8">
                        <div class="rounded-lg bg-white px-4 py-3 shadow-sm sm:px-6 dark:bg-gray-800">
                            {{ $this->data->onEachSide(1)->links() }}
                        </div>
                    </div>
                @endif
            </div>
        @else
            <div class="text-center py-8">
                <svg
                    class="mx-auto h-12 w-12 text-gray-400"
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
                <p class="mt-2 text-gray-600 dark:text-gray-400">No enrollments yet</p>
                <p class="text-sm text-gray-500 dark:text-gray-500">Start learning by enrolling in a course</p>
            </div>
        @endif
    </div>
</div>

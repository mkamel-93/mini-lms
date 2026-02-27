<div class="bg-white dark:bg-gray-800 rounded-xl border border-neutral-200 dark:border-neutral-700">
    <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Recent Certificates</h2>
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
                @foreach ($this->data as $certificate)
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="flex-1">
                            <h3 class="font-medium text-gray-900 dark:text-white">{{ $certificate->course->title }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Issued on
                                {{ $certificate->created_at->format('M d, Y') }}</p>
                        </div>
                        <div
                            class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-3 py-1 rounded-full text-sm">
                            Completed
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
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                    ></path>
                </svg>
                <p class="mt-2 text-gray-600 dark:text-gray-400">No certificates yet</p>
                <p class="text-sm text-gray-500 dark:text-gray-500">Complete courses to earn certificates</p>
            </div>
        @endif
    </div>
</div>

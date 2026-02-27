<!-- Enrollment Card -->
<div class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow-sm p-6 sticky top-6">
    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-4">
        {{ __('Get Started') }}
    </h3>
    @if (session()->has('error'))
        <div
            class="mb-4 p-3 text-sm text-red-600 bg-red-50 dark:bg-red-900/30 dark:text-red-400 rounded-lg border border-red-200 dark:border-red-800">
            {{ session('error') }}
        </div>
    @endif
    @auth
        @if ($this->isEnrolled)
            <button
                class="w-full px-4 py-3 text-base font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                wire:click="unenroll"
                wire:loading.attr="disabled"
                wire:target="unenroll"
            >
                <span
                    wire:loading.remove
                    wire:target="unenroll"
                >{{ __('Unenroll from Course') }}</span>
                <span
                    wire:loading
                    wire:target="unenroll"
                >{{ __('Processing...') }}</span>
            </button>
        @else
            <button
                class="w-full px-4 py-3 text-base font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                wire:click="enroll"
                wire:loading.attr="disabled"
                wire:target="enroll"
            >
                <span
                    wire:loading.remove
                    wire:target="enroll"
                >{{ __('Enroll in Course') }}</span>
                <span
                    wire:loading
                    wire:target="enroll"
                >{{ __('Enrolling...') }}</span>
            </button>
        @endif
    @else
        <div class="space-y-3">
            <a
                class="block w-full px-4 py-3 text-base font-medium text-blue-600 dark:text-blue-400 border border-blue-600 dark:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900 rounded-lg transition-colors text-center"
                href="{{ route('login') }}"
                wire:navigate
            >
                {{ __('Login to Enroll') }}
            </a>
        </div>
    @endauth
</div>

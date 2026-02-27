<div class="bg-white dark:bg-gray-800 rounded-xl border border-neutral-200 dark:border-neutral-700">
    <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Profile Summary</h2>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Full Name</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Email Address</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $user->email }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Member Since</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $user->created_at->format('M d, Y') }}</p>
            </div>
        </div>
    </div>
</div>

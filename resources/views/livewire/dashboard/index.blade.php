<div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl p-6 text-white">
        <h1 class="text-3xl font-bold mb-2">Welcome back, {{ $user->name }}!</h1>
        <p class="text-blue-100">Here's your learning progress and achievements</p>
    </div>

    <!-- Profile Summary -->
    <livewire:dashboard.sections.profile-summary-section :user="$user" />

    <!-- Recent Enrollments -->
    <livewire:dashboard.sections.recent-enrollments-section :user="$user" />

    <!-- Recent Certificates -->
    <livewire:dashboard.sections.recent-certificates-section :user="$user" />
</div>

<div class="container mx-auto px-4 py-12">
    <!-- Course Header Section -->
    <livewire:course.sections.course-header-section :course="$course" />

    <!-- Course Content -->
    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Course Content Section -->
            <livewire:course.sections.course-content-section :course="$course" />
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Course Enrollment Section -->
            <livewire:course.sections.course-enrollment-section :course="$course" />
        </div>
    </div>
</div>

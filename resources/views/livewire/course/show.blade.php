<div class="container mx-auto px-4 py-12">
    <livewire:course.sections.course-header-section
        :course="$course"
        :key="'header-' . $course->id . '-' . $course->students_count"
    />

    <div class="grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <livewire:course.sections.course-content-section
                :course="$course"
                :key="'content-' . $course->id . '-' . $course->students_count"
            />
        </div>

        <div class="lg:col-span-1">
            <livewire:course.sections.course-enrollment-section
                :course="$course"
                :key="'enroll-' . $course->id . '-' . $course->students_count"
            />
        </div>
    </div>
</div>

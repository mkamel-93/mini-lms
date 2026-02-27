@php
    $sizeClasses = match ($size ?? 'sm') {
        'sm' => 'px-2 py-1 text-xs',
        'md' => 'px-3 py-1 text-sm',
        'lg' => 'px-4 py-2 text-base',
        default => 'px-2 py-1 text-xs',
    };

    $colorClasses = match ($course->level->value) {
        'beginner' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
        'intermediate' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
        'advanced' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
        default => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200',
    };

    $classes = 'inline-flex items-center rounded-full font-medium ' . $sizeClasses . ' ' . $colorClasses;
@endphp

<span class="{{ $classes }}">
    {{ ucfirst($course->level->value) }}
</span>

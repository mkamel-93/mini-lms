<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'course.course-index')->name('home');
Route::livewire('/courses/{course:slug}', 'course.course-show')->name('courses.show');
Route::livewire('/courses/{course:slug}/lessons/{lesson:id}', 'course.lesson.lesson-show')->name('courses.lessons.show');

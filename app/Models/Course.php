<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use App\Enums\StatusEnum;
use App\Enums\CourseLevelEnum;
use Database\Factories\CourseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $slug
 * @property StatusEnum $status
 * @property CourseLevelEnum $level
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, Lesson> $lessons
 * @property-read Collection<int, User>   $students
 */
class Course extends BaseModel
{
    /** @use HasFactory<CourseFactory> */
    use HasFactory;

    use SoftDeletes;

    /**
     * The attributes that are mass-assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'description',
        'slug',
        'status',
        'level',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => StatusEnum::class,
        'level' => CourseLevelEnum::class,
    ];

    /**
     * @return HasMany<Lesson, $this>
     */
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    /**
     * @return BelongsToMany<User, $this>
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'enrollments')
            ->withTimestamps();
    }

    /**
     * Scope a query to only include active courses.
     *
     * @param  Builder<Course>  $query
     * @return Builder<Course>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', StatusEnum::ACTIVE);
    }
}

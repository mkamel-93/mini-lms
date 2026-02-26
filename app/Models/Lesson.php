<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use App\Enums\StatusEnum;
use Database\Factories\LessonFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $course_id
 * @property string $title
 * @property string $video_url
 * @property int $order
 * @property StatusEnum $status
 * @property bool $is_preview
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Course $course
 */
class Lesson extends BaseModel
{
    /** @use HasFactory<LessonFactory> */
    use HasFactory;

    use SoftDeletes;

    /**
     * The attributes that are mass-assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'course_id',
        'title',
        'video_url',
        'order',
        'status',
        'is_preview',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => StatusEnum::class,
        'order' => 'integer',
        'is_preview' => 'boolean',
    ];

    /**
     * @return BelongsTo<Course, $this>
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Scope a query to only include active lessons.
     *
     * @param  Builder<Lesson>  $query
     * @return Builder<Lesson>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', StatusEnum::ACTIVE);
    }
}

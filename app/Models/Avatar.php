<?php

namespace App\Models;

use App\Helpers\FileHelper;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string $avatar_url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Customer> $customers
 * @property-read int|null $customers_count
 * @property-read string $formatted_size
 * @property-read string $thumbnail_url
 *
 * @method static Builder<static>|Avatar newModelQuery()
 * @method static Builder<static>|Avatar newQuery()
 * @method static Builder<static>|Avatar query()
 * @method static Builder<static>|Avatar whereAvatarUrl($value)
 * @method static Builder<static>|Avatar whereCreatedAt($value)
 * @method static Builder<static>|Avatar whereId($value)
 * @method static Builder<static>|Avatar whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class Avatar extends Model
{
    use HasFactory;

    protected $table = 'avatars';

    protected $primaryKey = 'id';

    protected $fillable = [
        'original_name',
        'filename',
        'path',
        'avatar_url',
        'mime_type',
        'size',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'size' => 'integer',
    ];

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, 'avatar_id');
    }

    /**
     * Get human-readable file size
     */
    public function getFormattedSizeAttribute(): string
    {
        return FileHelper::formatFileSize($this->size);
    }

    /**
     * Get thumbnail URL (for smaller avatar sizes)
     */
    public function getThumbnailUrlAttribute(): string
    {
        return $this->avatar_url;
    }

    /**
     * Delete the avatar from storage when model is deleted
     */
    protected static function booted(): void
    {
        static::deleting(function (Avatar $avatar) {
            if ($avatar->path) {
                Storage::disk('supabase')->delete($avatar->path);
            }
        });
    }
}

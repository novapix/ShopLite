<?php

namespace App\Models;

use App\Helpers\FileHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

/**
 * @property-read \App\Models\Brand|null $brand
 * @property-read string $formatted_size
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BrandImage banners()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BrandImage logos()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BrandImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BrandImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BrandImage ofType(string $type)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BrandImage query()
 *
 * @mixin \Eloquent
 */
class BrandImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'original_name',
        'filename',
        'path',
        'url',
        'alt_text',
        'type',
        'mime_type',
        'size',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'size' => 'integer',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get human-readable file size
     */
    public function getFormattedSizeAttribute(): string
    {
        return FileHelper::formatFileSize($this->size);
    }

    /**
     * Delete the image from storage when model is deleted
     */
    protected static function booted(): void
    {
        static::deleting(function (BrandImage $image) {
            Storage::disk('supabase')->delete($image->path);
        });
    }

    /**
     * Scope to get images by type
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope to get logo images
     */
    public function scopeLogos($query)
    {
        return $query->where('type', 'logo');
    }

    /**
     * Scope to get banner images
     */
    public function scopeBanners($query)
    {
        return $query->where('type', 'banner');
    }
}

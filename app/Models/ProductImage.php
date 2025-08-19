<?php

namespace App\Models;

use App\Helpers\FileHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

/**
 * @property-read string $formatted_size
 * @property-read string $thumbnail_url
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImage ordered()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImage primary()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImage query()
 *
 * @mixin \Eloquent
 */
class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'original_name',
        'filename',
        'path',
        'url',
        'alt_text',
        'sort_order',
        'is_primary',
        'mime_type',
        'size',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_primary' => 'boolean',
        'size' => 'integer',
        'sort_order' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get human readable file size
     */
    public function getFormattedSizeAttribute(): string
    {
        return FileHelper::formatFileSize($this->size);

    }

    /**
     * Get thumbnail URL (you can implement image transformation here)
     */
    public function getThumbnailUrlAttribute(): string
    {
        // For now return the same URL, but you can implement Supabase image transformations
        return $this->url;
    }

    /**
     * Delete the image from storage when model is deleted
     */
    protected static function booted(): void
    {
        static::deleting(function (ProductImage $image) {
            Storage::disk('supabase')->delete($image->path);
        });
    }

    /**
     * Scope to get primary images
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    /**
     * Scope to order by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }
}

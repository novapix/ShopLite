<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder<static>|Brand newModelQuery()
 * @method static Builder<static>|Brand newQuery()
 * @method static Builder<static>|Brand query()
 * @method static Builder<static>|Brand whereCreatedAt($value)
 * @method static Builder<static>|Brand whereDescription($value)
 * @method static Builder<static>|Brand whereId($value)
 * @method static Builder<static>|Brand whereName($value)
 * @method static Builder<static>|Brand whereStatus($value)
 * @method static Builder<static>|Brand whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class Brand extends Model
{
    use HasFactory;

    protected $table = 'brands';

    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    protected $primaryKey = 'id';

    public function logo(): HasOne
    {
        return $this->hasOne(BrandImage::class)->where('type', 'logo');
    }

    public function images(): HasMany
    {
        return $this->hasMany(BrandImage::class);
    }
}

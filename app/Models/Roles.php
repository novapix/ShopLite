<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * 
 *
 * @property int $id
 * @property string $role
 * @property int $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder<static>|Roles newModelQuery()
 * @method static Builder<static>|Roles newQuery()
 * @method static Builder<static>|Roles query()
 * @method static Builder<static>|Roles whereCreatedAt($value)
 * @method static Builder<static>|Roles whereId($value)
 * @method static Builder<static>|Roles whereIsActive($value)
 * @method static Builder<static>|Roles whereRole($value)
 * @method static Builder<static>|Roles whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Roles extends Model
{
    use HasFactory;

    protected $fillable = [
        'role',
        'is_active',
        'created_at',
        'updated_at'
    ];
    protected $primaryKey = 'id';
}

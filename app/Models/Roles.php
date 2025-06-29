<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

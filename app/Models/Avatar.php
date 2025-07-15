<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    protected $table = 'avatars';
    protected $primaryKey = 'id';
    protected $fillable = [
        'avatar_url',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneratedProject extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'db_type',
        'db_name',
        'db_port',
        'db_username',
        'ai_prompt',
        'path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

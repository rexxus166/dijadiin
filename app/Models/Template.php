<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Template extends Model
{
    protected $fillable = [
        'created_by',
        'name',
        'slug',
        'description',
        'category',
        'thumbnail',
        'zip_path',
        'downloads',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail && file_exists(storage_path('app/public/' . $this->thumbnail))) {
            return asset('storage/' . $this->thumbnail);
        }
        return asset('assets/img/template-placeholder.png');
    }

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }
}

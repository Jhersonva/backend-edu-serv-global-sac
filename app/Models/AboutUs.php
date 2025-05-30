<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    protected $table = 'about_us';

    protected $fillable = [
        'description',
        'mission',
        'vision',
        'history',
        'values',
        'video_url',
        'video_description',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'values' => 'array',
    ];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Links extends Model
{
    protected $table = 'links';
    protected $fillable = [
        'name',
        'description',
        'url',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}

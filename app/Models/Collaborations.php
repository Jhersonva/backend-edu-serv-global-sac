<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collaborations extends Model
{
    protected $table = 'Collaborations';
    protected $fillable = [
        'name',
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

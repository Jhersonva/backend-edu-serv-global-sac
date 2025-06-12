<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Project extends Model
{
    protected $fillable = ['title', 'description'];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function services()
    {
        return $this->hasMany(ServicesCategory::class, 'id_projects');
    }
}


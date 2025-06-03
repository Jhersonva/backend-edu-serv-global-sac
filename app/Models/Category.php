<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Category extends Model
{
    protected $fillable = ['name', 'description'];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}



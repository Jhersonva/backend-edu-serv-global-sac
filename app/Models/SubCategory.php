<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class SubCategory extends Model
{
    protected $fillable = ['description', 'benefits', 'category_id'];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'benefits' => 'array',
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}



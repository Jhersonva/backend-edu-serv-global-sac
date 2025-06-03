<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Service extends Model
{
    protected $fillable = ['sub_category_id', 'title', 'description', 'benefits'];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    
    protected $casts = [
        'benefits' => 'array',
    ];

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}



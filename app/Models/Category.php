<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Category extends Model
{
    protected $fillable = ['name', 'description', 'id_services_category'];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    
    public function serviceCategories()
    {
        return $this->belongsToMany(ServicesCategory::class, 'category_service_category', 'category_id', 'service_category_id');
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
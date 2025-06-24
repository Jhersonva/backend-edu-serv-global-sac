<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class ServicesCategory extends Model
{
    protected $table = 'services_category';

    protected $fillable = ['title', 'description', 'benefits'];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    
    protected $casts = [
        'benefits' => 'array',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_service_category', 'service_category_id', 'project_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_service_category', 'service_category_id', 'category_id');
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class ServicesCategory extends Model
{
    protected $table = 'services_category';

    protected $fillable = ['title', 'description', 'benefits', 'id_projects'];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    
    protected $casts = [
        'benefits' => 'array',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'id_projects');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'id_services_category');
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}


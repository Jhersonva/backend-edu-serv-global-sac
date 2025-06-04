<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
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

// public function services(): HasManyThrough
    //{
      //  return $this->hasManyThrough(
        //    Service::class,        // Modelo destino
          //  SubCategory::class,    // Modelo intermedio
            //'category_id',         // FK en SubCategory → Category
            //'sub_category_id',     // FK en Service → SubCategory
            //'id',                  // PK en Category
            //'id'                   // PK en SubCategory
        //);
    //}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    protected $table = 'homes';
    protected $fillable = ['title', 'first_description', 'second_description'];
    protected $hidden = ['created_at', 'updated_at'];
public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}

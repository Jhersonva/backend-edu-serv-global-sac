<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    protected $fillable = [
        'comment',
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

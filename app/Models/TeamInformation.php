<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamInformation extends Model
{
    protected $table = 'team_informations';
    protected $fillable = [
        'full_name',
        'rol',
        'description',
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

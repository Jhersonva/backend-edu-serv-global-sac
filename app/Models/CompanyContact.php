<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyContact extends Model
{
    use HasFactory;

    protected $table = 'company_contact';

    protected $fillable = [
        'address',
        'phone',
        'email',
        'url_map',
        'cordenadas_map',
    ];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}

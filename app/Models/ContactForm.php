<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactForm extends Model
{
    protected $table = 'contact_form';
    protected $fillable = [
        'full_name',
        'email',
        'message',
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

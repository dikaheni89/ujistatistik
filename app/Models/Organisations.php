<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organisations extends Model
{
    protected $table = 'organisations';

    protected $fillable = [
        'organisation_name',
        'description',
        'image',
        'slug',
    ];

    public function datasets()
    {
        return $this->hasMany(Datasets::class, 'organisation_id');
    }
}

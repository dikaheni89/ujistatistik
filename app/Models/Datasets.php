<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Datasets extends Model
{
    protected $table = 'datasets';

    protected $fillable = [
        'organisation_id',
        'name',
        'title',
        'author',
        'author_email',
        'maintainer',
        'maintainer_email',
        'license_id',
        'notes',
        'url',
        'version',
        'private',
    ];

    public function organisation()
    {
        return $this->belongsTo(Organisations::class, 'organisation_id');
    }

    public function tags()
    {
        return $this->hasMany(Tags::class, 'dataset_id');
    }

    public function extras()
    {
        return $this->hasMany(Extras::class, 'dataset_id');
    }

    public function resources()
    {
        return $this->hasMany(Resources::class, 'dataset_id');
    }
}

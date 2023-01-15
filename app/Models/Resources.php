<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resources extends Model
{
    protected $table = 'resources';
    protected $primaryKey = 'id';
    protected $fillable = [
        'dataset_id',
        'name',
        'url',
        'description',
        'format',
        'upload',
        'resource_id',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extras extends Model
{
    protected $table = 'extras';

    protected $fillable = [
        'dataset_id',
        'key',
        'value',
    ];
}

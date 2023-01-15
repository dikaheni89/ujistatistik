<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BapendaSheet2 extends Model
{
    protected $table = 'bapenda_sheet2';

    protected $fillable = [
        'kode_kabupaten',
        'nama_kabupaten',
        'tahun',
        'nama_opd',
        'nama_inovasi_daerah',
    ];
}

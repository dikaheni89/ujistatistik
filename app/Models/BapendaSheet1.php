<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BapendaSheet1 extends Model
{
    protected $table = 'bapenda_sheet1';

    protected $fillable = [
        'resource_id',
        'kode_kabupaten',
        'nama_kabupaten',
        'jenis_pajak_daerah',
        'tahun',
        'jumlah_target',
        'satuan',
    ];
}

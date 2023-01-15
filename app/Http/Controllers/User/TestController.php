<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BapendaSheet1;
use App\Models\Resources;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index($id)
    {
        $resource = Resources::find($id);
        $title    = 'Add Resource ' . $resource->name;

        return view('user.test.index', compact('title', 'resource'));
    }
    //
    public function store(Request $request, $id)
    {
        BapendaSheet1::create([
            'resource_id'       => $id,
            'kode_kabupaten'    => $request->kode_kabupaten,
            'nama_kabupaten'    => $request->nama_kabupaten,
            'jenis_pajak_daerah' => $request->jenis_pajak_daerah,
            'tahun'             => $request->tahun,
            'jumlah_target'     => $request->jumlah_target,
            'satuan'            => $request->satuan,
        ]);

        return redirect()->route('test.index', $id)->with('success', 'Data berhasil disimpan');
    }
}

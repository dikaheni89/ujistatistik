<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BapendaSheet1;
use App\Models\Datasets;
use App\Models\Resources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ResourceController extends Controller
{
    public function index($id)
    {
        $title    = 'Resources';
        $dataset  = Datasets::with('organisation', 'tags', 'resources', 'extras')->find($id);

        return view('user.resources.index', compact('dataset', 'title'));
    }
    //
    public function storeNew(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $dataset = Datasets::find($id);
        //
        try {
            DB::beginTransaction();
            $response = Http::withHeaders(['Authorization' => config('ckan.api_key')])->post(config('ckan.endpoint') . 'api/3/action/resource_create', [
                'package_id'        => $dataset->name,
                'description'       => $request->description,
                'name'              => $request->name,
            ]);
            if ($response->successful()) {
                Resources::create([
                    'dataset_id'    => $id,
                    'name'          => $request->name,
                    'description'   => $request->description,
                    'resource_id'   => $response->json()['result']['id'],
                ]);
            }
            DB::commit();
            return redirect()->route('resources.index', $id)->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //
    public function newResource($id)
    {
        $title = 'Tambah Resource';
        $dataset  = Datasets::with('organisation', 'tags', 'resources', 'extras')->find($id);

        return view('user.resources.new', compact('dataset', 'title'));
    }
    //
    public function syncron($id)
    {
        $resource    = Resources::where('id', $id)->first();
        $dataResoure = BapendaSheet1::where('resource_id', $id)->get();
        $json        = json_encode($dataResoure);
        $fileName    = time() . '.json';
        $file        = file_put_contents(('uploads/' . $fileName), $json);
        $url         = url('uploads/' . $fileName);
        try {
            DB::beginTransaction();
            $response = Http::withHeaders(['Authorization' => config('ckan.api_key')])->post(config('ckan.endpoint') . 'api/3/action/resource_update', [
                'id'                => $resource->resource_id,
                'url'               => $url,
                'format'            => 'json',
            ]);
            if ($response->successful()) {
                $resource->update([
                    'upload'        => $file,
                    'url'           => $url,
                ]);
                DB::commit();
                return redirect()->route('resources.index', $resource->dataset_id)->with('success', 'Data berhasil diubah');
            } else {
                DB::rollBack();
                return redirect()->back()->with('error', 'Data gagal diubah');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Data gagal diubah');
        }
    }
    //
    public function create($id)
    {
        $title    = 'Tambah Resource';
        $dataset  = Datasets::with('organisation', 'tags', 'resources', 'extras')->find($id);

        return view('user.resources.create', compact('dataset', 'title'));
    }
    //
    public function edit($id)
    {
        $title    = 'Edit Resource';
        $resource = Resources::where('resource_id', $id)->first();

        return view('user.resources.edit', compact('title', 'resource'));
    }
    //
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'file' => 'mimes:xls,xlsx,csv,txt,json,xml|max:2048',
        ]);

        $resource = Resources::where('resource_id', $id)->first();
        if ($request->has('file')) {
            $fileName = time() . '_' . $request->file->getClientOriginalExtension();
            $format = $request->file->getClientOriginalExtension();
            $file = $request->file('file');
            $request->file->move(public_path('uploads'), $fileName);
            $url  = url('uploads/' . $fileName);
        } else {
            $format = $resource->format;
            $file = $resource->upload;
            $url  = $resource->url;
        }

        try {
            DB::beginTransaction();
            $response = Http::withHeaders(['Authorization' => config('ckan.api_key')])->post(config('ckan.endpoint') . 'api/3/action/resource_update', [
                'id'                => $resource->resource_id,
                'url'               => $url,
                'description'       => $request->description,
                'format'            => $format,
                'name'              => $request->name,
            ]);
            if ($response->successful()) {
                $resource->update([
                    'name'          => $request->name,
                    'description'   => $request->description,
                    'format'        => $format,
                    'upload'        => $file,
                    'url'           => $url,
                ]);
                DB::commit();
                return redirect()->route('resources.index', $resource->dataset_id)->with('success', 'Data berhasil diubah');
            } else {
                DB::rollBack();
                return redirect()->back()->with('error', 'Data gagal diubah');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Data gagal diubah');
        }
    }
    //
    public function store(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'file' => 'required|mimes:xls,xlsx,csv,txt,json,xml|max:2048',
        ]);
        $dataset = Datasets::find($id);
        //
        $fileName = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('uploads'), $fileName);
        $url = url('uploads/' . $fileName);
        //
        try {
            DB::beginTransaction();
            $response = Http::withHeaders(['Authorization' => config('ckan.api_key')])->post(config('ckan.endpoint') . 'api/3/action/resource_create', [
                'package_id'        => $dataset->name,
                'url'               => $url,
                'description'       => $request->description,
                'format'            => $request->file->getClientOriginalExtension(),
                'name'              => $request->name,
            ]);
            if ($response->successful()) {
                Resources::create([
                    'dataset_id'    => $id,
                    'name'          => $request->name,
                    'url'           => $url,
                    'description'   => $request->description,
                    'format'        => $request->file->getClientOriginalExtension(),
                    'upload'        => $fileName,
                    'resource_id'   => $response->json()['result']['id'],
                ]);
            }
            DB::commit();
            return redirect()->route('resources.index', $id)->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //
    public function preview($id)
    {
        $resource = Resources::where('resource_id', $id)->first()->upload;

        $download = public_path('uploads/' . $resource);

        return response()->download($download);
    }
    //
    public function destroy($id)
    {
        //
        try {
            DB::beginTransaction();
            $resource = Resources::where('resource_id', $id)->first();
            //save to ckan
            $response = Http::withHeaders(['Authorization' => config('ckan.api_key')])->post(config('ckan.endpoint') . 'api/3/action/resource_delete', [
                'id'            => $resource->resource_id,
            ]);

            if ($response->successful()) {
                $resource->delete();
            } else {
                return redirect()->back()->with('error', 'Gagal menyimpan data organisasi');
            }
            DB::commit();
            return redirect()->back()->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data gagal dihapus');
        }
    }
}

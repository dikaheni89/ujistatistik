<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organisations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class OrganitasionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $response = Http::withHeaders(['Authorization' => config('ckan.api_key')])->post(config('ckan.endpoint') . 'api/3/action/organization_list', [
        //     'offset' => 49,
        //     'all_fields' => true,
        // ]);

        // $organisations = $response->json()['result'];
        // $organisations = collect($organisations)->map(function ($organisation) {
        //     Organisations::updateOrCreate([
        //         'organisation_name' => $organisation['title'],
        //         'description'       => $organisation['description'],
        //         'image'             => $organisation['image_url'],
        //         'slug'              => $organisation['name'],
        //     ]);
        // });
        // dd($organisations);

        $title          = 'Data Organisasi';
        $organisations  = Organisations::orderBy('organisation_name', 'asc')->get();

        return view('admin.organisations.index', compact('title', 'organisations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Tambah Organisasi';

        return view('admin.organisations.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'organisation_name' => 'required'
        ]);
        //
        try {
            DB::beginTransaction();
            //save to ckan
            $response = Http::withHeaders(['Authorization' => config('ckan.api_key')])->post(config('ckan.endpoint') . 'api/3/action/organization_create', [
                'name'          => Str::slug($request->organisation_name),
                'title'         => ucwords($request->organisation_name),
                'description'   => $request->description,
                'image_url'     => $request->image,
                'state'         => 'active'
            ]);

            if ($response->successful()) {
                Organisations::create([
                    'organisation_name' => ucwords($request->organisation_name),
                    'description'       => ucwords($request->description),
                    'image'             => $request->image,
                    'slug'              => Str::slug($request->organisation_name)
                ]);
            } else {
                return redirect()->back()->with('error', 'Gagal menyimpan data organisasi');
            }
            DB::commit();
            return redirect()->route('admin.organisations.index')->with('success', 'Data organisasi berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('admin.organisations.index')->with('error', 'Data organisasi gagal ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title          = 'Edit Organisasi';
        $organisation   = Organisations::findOrFail($id);

        return view('admin.organisations.edit', compact('title', 'organisation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'organisation_name' => 'required'
        ]);
        //
        try {
            DB::beginTransaction();
            $organisation = Organisations::findOrFail($id);
            //save to ckan
            $response = Http::withHeaders(['Authorization' => config('ckan.api_key')])->post(config('ckan.endpoint') . 'api/3/action/organization_update', [
                'id'            => $organisation->slug,
                'name'          => Str::slug($request->organisation_name),
                'title'         => ucwords($request->organisation_name),
                'description'   => $request->description,
                'image_url'     => $request->image,
                'state'         => 'active'
            ]);

            if ($response->successful()) {
                $organisation->update([
                    'organisation_name' => ucwords($request->organisation_name),
                    'description'       => ucwords($request->description),
                    'image'             => $request->image,
                    'slug'              => Str::slug($request->organisation_name)
                ]);
            } else {
                return redirect()->back()->with('error', 'Gagal menyimpan data organisasi');
            }
            DB::commit();
            return redirect()->route('admin.organisations.index')->with('success', 'Data organisasi berhasil diubah');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('admin.organisations.index')->with('error', 'Data organisasi gagal diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try {
            DB::beginTransaction();
            $organisation = Organisations::findOrFail($id);
            //save to ckan
            $response = Http::withHeaders(['Authorization' => config('ckan.api_key')])->post(config('ckan.endpoint') . 'api/3/action/group_purge', [
                'id'            => $organisation->slug,
            ]);

            if ($response->successful()) {
                $organisation->delete();
            } else {
                return redirect()->back()->with('error', 'Gagal menyimpan data organisasi');
            }
            DB::commit();
            return redirect()->route('admin.organisations.index')->with('success', 'Data organisasi berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('admin.organisations.index')->with('error', 'Data organisasi gagal ditambahkan');
        }
    }
}

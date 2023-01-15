<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Groups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title  = 'Data Group';
        $groups = Groups::orderBy('group_name', 'ASC')->get();

        return view('admin.groups.index', compact('title', 'groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Tambah Group';

        return view('admin.groups.create', compact('title'));
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
            'group_name' => 'required'
        ]);
        //
        try {
            DB::beginTransaction();
            //save to ckan
            $response = Http::withHeaders(['Authorization' => config('ckan.api_key')])->post(config('ckan.endpoint') . 'api/3/action/group_create', [
                'name'          => Str::slug($request->group_name),
                'title'         => ucwords($request->group_name),
                'description'   => $request->description,
                'image_url'     => $request->image,
                'state'         => 'active'
            ]);

            if ($response->successful()) {
                Groups::create([
                    'group_name'        => ucwords($request->group_name),
                    'description'       => ucwords($request->description),
                    'image'             => $request->image,
                    'slug'              => Str::slug($request->group_name)
                ]);
            } else {
                return redirect()->back()->with('error', 'Gagal menyimpan data grup');
            }
            DB::commit();
            return redirect()->route('admin.groups.index')->with('success', 'Data grup berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('admin.groups.index')->with('error', 'Data grup gagal ditambahkan');
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
        $title  = 'Edit Group';
        $group  = Groups::findOrFail($id);

        return view('admin.groups.edit', compact('title', 'group'));
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
            'group_name' => 'required'
        ]);
        //
        try {
            DB::beginTransaction();
            $group = Groups::findOrFail($id);
            //save to ckan
            $response = Http::withHeaders(['Authorization' => config('ckan.api_key')])->post(config('ckan.endpoint') . 'api/3/action/group_update', [
                'id'            => $group->slug,
                'name'          => Str::slug($request->group_name),
                'title'         => ucwords($request->group_name),
                'description'   => $request->description,
                'image_url'     => $request->image,
                'state'         => 'active'
            ]);

            if ($response->successful()) {
                $group->update([
                    'group_name'        => ucwords($request->group_name),
                    'description'       => ucwords($request->description),
                    'image'             => $request->image,
                    'slug'              => Str::slug($request->group_name)
                ]);
            } else {
                return redirect()->back()->with('error', 'Gagal menyimpan data grup');
            }
            DB::commit();
            return redirect()->route('admin.groups.index')->with('success', 'Data grup berhasil diubah');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('admin.groups.index')->with('error', 'Data grup gagal diubah');
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
            $group = Groups::findOrFail($id);
            //save to ckan
            $response = Http::withHeaders(['Authorization' => config('ckan.api_key')])->post(config('ckan.endpoint') . 'api/3/action/group_purge', [
                'id'            => $group->slug,
            ]);

            if ($response->successful()) {
                $group->delete();
            } else {
                return redirect()->back()->with('error', 'Gagal menyimpan data organisasi');
            }
            DB::commit();
            return redirect()->route('admin.groups.index')->with('success', 'Data organisasi berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('admin.groups.index')->with('error', 'Data organisasi gagal ditambahkan');
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organisations;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Data User';
        $users = User::with('organisations')->latest()->get();

        return view('admin.user.index', compact('title', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Tambah User';
        $organisations = Organisations::orderBy('organisation_name', 'ASC')->get();

        return view('admin.user.create', compact('title', 'organisations'));
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
            'organisation'  => 'required',
            'name'          => 'required',
            'email'         => 'required|email|unique:users',
            'password'      => 'required|min:7',
        ]);

        User::create([
            'organisation_id'   => $request->organisation,
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => bcrypt($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil ditambahkan');
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
        $title          = 'Edit User';
        $user           = User::with('organisations')->findOrFail($id);
        $organisations  = Organisations::orderBy('organisation_name', 'ASC')->get();

        return view('admin.user.edit', compact('title', 'user', 'organisations'));
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
            'organisation'  => 'required',
            'name'          => 'required',
            'email'         => 'required|email|unique:users,email,' . $id,
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'organisation_id'   => $request->organisation,
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil dihapus');
    }
}

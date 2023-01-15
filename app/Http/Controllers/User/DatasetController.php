<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Datasets;
use App\Models\Extras;
use App\Models\Licenses;
use App\Models\Organisations;
use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DatasetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title      = 'Datasets';
        $datasets   = Datasets::where('organisation_id', auth()->user()->organisation_id)->get();

        return view('user.datasets.index', compact('title', 'datasets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title         = 'Tambah Dataset';
        $response      = Http::accept('application/json')->get(config('ckan.endpoint') . 'api/3/action/tag_list');
        $tags          = $response->json()['result'];
        $licenses      = Licenses::orderBy('title', 'asc')->get();

        return view('user.datasets.create', compact('title', 'tags', 'licenses'));
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
            'title'         => 'required|unique:datasets,title',
            'licence'       => 'required',
            'private'       => 'required',
        ]);
        try {
            DB::beginTransaction();
            //add tags
            if (!empty($request->tags)) {
                $tags = $this->tags($request->tags);
            } else {
                $tags = array();
            }
            $filtered = array_filter($request->custom_field_key, function ($var) {
                return !is_null($var);
            });
            //add extras
            if ($filtered != null) {
                $extras = $this->extras($request->custom_field_key, $request->custom_field_value);
            } else {
                $extras = array();
            }
            //add post dataset
            $organisation = Organisations::where('id', auth()->user()->organisation_id)->first();
            $response = Http::withHeaders(['Authorization' => config('ckan.api_key')])->post(config('ckan.endpoint') . 'api/3/action/package_create', [
                'name'              => Str::slug($request->title),
                'owner_org'         => str_replace(' ', '', $organisation->slug),
                'title'             => $request->title,
                'author'            => $request->author,
                'author_email'      => $request->author_email,
                'maintainer'        => $request->maintainer,
                'maintainer_email'  => $request->maintainer_email,
                'license_id'        => $request->licence,
                'notes'             => $request->description,
                'url'               => $request->url,
                'version'           => $request->version,
                'state'             => 'active',
                'private'           => $request->private,
                'tags'              => $tags,
                'extras'            => $extras,
            ]);

            if ($response->successful()) {
                $dataset = Datasets::create([
                    'organisation_id'   => $organisation->id,
                    'name'              => Str::slug($request->title),
                    'title'             => $request->title,
                    'author'            => $request->author,
                    'author_email'      => $request->author_email,
                    'maintainer'        => $request->maintainer,
                    'maintainer_email'  => $request->maintainer_email,
                    'license_id'        => $request->licence,
                    'notes'             => $request->description,
                    'url'               => $request->url,
                    'version'           => $request->version,
                    'private'           => $request->private,
                ]);

                if ($request->tags) {
                    foreach ($request->tags as $tag) {
                        $dataset->tags()->create([
                            'dataset_id'    => $dataset->id,
                            'name'          => $tag,
                        ]);
                    }
                }

                if ($filtered != null) {
                    foreach ($request->custom_field_key as $key => $value) {
                        $dataset->extras()->create([
                            'dataset_id'    => $dataset->id,
                            'key'           => $value,
                            'value'         => $request->custom_field_value[$key],
                        ]);
                    }
                }

                DB::commit();
                return redirect()->route('datasets.index')->with('success', 'Dataset berhasil ditambahkan');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('datasets.index')->with('error', 'Dataset gagal ditambahkan');
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
        $title          = 'Edit Dataset';
        $dataset        = Datasets::where('id', $id)->first();
        $response       = Http::accept('application/json')->get(config('ckan.endpoint') . 'api/3/action/tag_list');
        $tags           = $response->json()['result'];
        $getTag         = [];
        $tagsDb         = Tags::where('dataset_id', $dataset->id)->get();
        $extras         = Extras::where('dataset_id', $dataset->id)->get();
        $licenses       = Licenses::orderBy('title', 'asc')->get();
        foreach ($tagsDb as $tagname) {
            $getTag[] = $tagname->name;
        }

        return view('user.datasets.edit', compact('title', 'dataset', 'tags', 'extras', 'licenses', 'tagsDb', 'getTag'));
    }
    //
    private function tags($tagsRequest)
    {
        $tags_for_ckan = array();
        foreach ($tagsRequest as $tag) array_push($tags_for_ckan, array('name' => rawurlencode($tag)));
        return $tags_for_ckan;
    }
    //
    private function extras($field, $vals)
    {
        $extras = array();
        foreach ($field as $key => $value) {
            $val = $vals[$key];
            array_push($extras, array('key' => $value, 'value' => $val));
        }
        return $extras;
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'         => 'required|unique:datasets,title,' . $id,
            'licence'       => 'required',
            'private'       => 'required',
        ]);
        try {
            DB::beginTransaction();
            //add tags
            if (!empty($request->tags)) {
                $tags = $this->tags($request->tags);
            } else {
                $tags = array();
            }
            //add extras
            if (!empty($request->custom_field_key)) {
                $extras = $this->extras($request->custom_field_key, $request->custom_field_value);
            } else {
                $extras = array();
            }
            //add post dataset
            $organisation = Organisations::where('id', auth()->user()->organisation_id)->first();
            $response = Http::withHeaders(['Authorization' => config('ckan.api_key')])->post(config('ckan.endpoint') . 'api/3/action/package_update', [
                'name'              => Str::slug($request->title),
                'owner_org'         => str_replace(' ', '', $organisation->slug),
                'title'             => $request->title,
                'author'            => $request->author,
                'author_email'      => $request->author_email,
                'maintainer'        => $request->maintainer,
                'maintainer_email'  => $request->maintainer_email,
                'license_id'        => $request->licence,
                'notes'             => $request->description,
                'url'               => $request->url,
                'version'           => $request->version,
                'state'             => 'active',
                'private'           => $request->private,
                'tags'              => $tags,
                'extras'            => $extras,
            ]);

            if ($response->successful()) {
                $dataset = Datasets::where('id', $id)->update([
                    'name'              => Str::slug($request->title),
                    'title'             => $request->title,
                    'author'            => $request->author,
                    'author_email'      => $request->author_email,
                    'maintainer'        => $request->maintainer,
                    'maintainer_email'  => $request->maintainer_email,
                    'license_id'        => $request->licence,
                    'notes'             => $request->description,
                    'url'               => $request->url,
                    'version'           => $request->version,
                    'private'           => $request->private,
                ]);

                $dataset = Datasets::where('id', $id)->first();

                if ($request->tags) {
                    Tags::where('dataset_id', $id)->delete();
                    foreach ($request->tags as $tag) {
                        $dataset->tags()->create([
                            'dataset_id'    => $dataset->id,
                            'name'          => $tag,
                        ]);
                    }
                }
                $filtered = array_filter($request->custom_field_key, function ($var) {
                    return !is_null($var);
                });

                if ($filtered != null) {
                    Extras::where('dataset_id', $id)->delete();
                    foreach ($request->custom_field_key as $key => $value) {
                        $dataset->extras()->create([
                            'dataset_id'    => $dataset->id,
                            'key'           => $value,
                            'value'         => $request->custom_field_value[$key],
                        ]);
                    }
                }

                DB::commit();
                return redirect()->route('datasets.index')->with('success', 'Dataset berhasil ditambahkan');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('datasets.index')->with('error', 'Dataset gagal ditambahkan');
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
            $dataset = Datasets::findOrFail($id);
            //save to ckan
            $response = Http::withHeaders(['Authorization' => config('ckan.api_key')])->post(config('ckan.endpoint') . 'api/3/action/dataset_purge', [
                'id'            => $dataset->name,
            ]);

            if ($response->successful()) {
                $dataset->delete();
            } else {
                return redirect()->back()->with('error', 'Gagal menghapus Dataset');
            }
            DB::commit();
            return redirect()->route('datasets.index')->with('success', 'Dataset berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('datasets.index')->with('error', 'Dataset gagal dihapus');
        }
    }
}

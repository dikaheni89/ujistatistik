@extends('user.theme.index')
@push('styles')
    <link href="{{ asset('theme/assets/css/users/user-profile.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('title', $title)
@section('content')
    <div class="layout-px-spacing">
        <!-- CONTENT AREA -->
        <div class="d-flex justify-content-between mt-3">
            <a href="{{ route('datasets.index') }}" class="btn btn-sm btn-danger font-weight-bold float-end">Kembali</a>
            <a href="{{ route('resource.new-resource', $dataset->id) }}"
                class="btn btn-sm btn-primary font-weight-bold float-end">Tambah Resource</a>
        </div>
        <div class="row layout-top-spacing">
            <div class="col-xl-3 col-lg-3 col-md-3 col-3 layout-spacing">
                <div class="widget-content-area br-4">
                    <div class="widget-one">
                        <h6 class="text-center text-black">{{ $dataset->title }}</h6>
                    </div>
                    <hr>
                    <div class="widget-one">
                        <h6 class="text-center text-black">Organisasi</h6>
                    </div>
                    <div class="text-center">
                        <img src="{{ $dataset->organisation->image }}" class="img-responsive" alt="">
                    </div>
                    <div class="text-center mt-3 text-black">
                        <span class="font-weight-bold">{{ $dataset->organisation->organisation_name }}</span>
                    </div>
                    <div class="text-center mt-1">
                        <p>{{ $dataset->organisation->description }}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-9 col-9 layout-spacing">
                <div class="bio layout-spacing ">
                    <div class="widget-content widget-content-area">
                        <h3 class="mb-3">Dataset</h3>
                        <p class="text-black">{{ $dataset->title }}</p>

                        <p class="text-black">{{ $dataset->notes }}</p>
                        <h3 class="">Resource</h3>
                        @if ($dataset->resources->count() > 0)
                            <div class="bio-skill-box">
                                <table class="table table-bordered table-striped mb-4">
                                    <thead>
                                        <tr>
                                            <th class="text-black">Nama</th>
                                            <th class="text-black">Deskripsi</th>
                                            <th class="text-black" style="width: 30%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataset->resources as $resource)
                                            <tr>
                                                <td class="text-black">{{ $resource->name }}</td>
                                                <td class="text-black">{{ $resource->description }}</td>
                                                <td>
                                                    {{-- <a href="{{ route('resources.edit', $resource->resource_id) }}"
                                                        class="btn btn-sm btn-warning font-weight-bold">Edit</a> --}}
                                                    <a href="{{ route('test.index', $resource->id) }}"
                                                        class="btn btn-sm btn-warning font-weight-bold">Tambah Data</a>
                                                    <a href="{{ route('resources.syncron', $resource->id) }}"
                                                        class="btn btn-sm btn-dark font-weight-bold">Syncronise</a>
                                                    {{-- <a href="{{ route('resources.preview', $resource->resource_id) }}"
                                                        class="btn btn-sm btn-dark font-weight-bold">Download</a> --}}
                                                    <form action="{{ route('resources.destroy', $resource->resource_id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-danger font-weight-bold">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="bio-skill-box">
                                <span class="text-black">Belum ada data resource</span>
                            </div>
                        @endif
                        <div class="mb-3 mt-2">
                            <h3 class="mb-3">Tag</h3>
                            @foreach ($dataset->tags as $tag)
                                <span class="badge badge-primary">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                        <div class="mb-3 mt-2">
                            <h3 class="mb-3">Aditional Info</h3>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-4">
                                    <thead>
                                        <tr>
                                            <th class="text-black">Field</th>
                                            <th class="text-black">Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="font-weight-bold text-black">Lisensi</td>
                                            <td class="text-black">{{ $dataset->license_id }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold text-black">Update</td>
                                            <td class="text-black">
                                                {{ \Carbon\Carbon::parse($dataset->updated_at)->locale('id')->isoFormat('LL') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold text-black">Dibuat</td>
                                            <td class="text-black">
                                                {{ \Carbon\Carbon::parse($dataset->created_at)->locale('id')->isoFormat('LL') }}
                                            </td>
                                        </tr>
                                        @foreach ($dataset->extras as $extra)
                                            <tr>
                                                <td class="font-weight-bold text-black">{{ $extra->key }}</td>
                                                <td class="text-black">
                                                    {{ $extra->value }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <!-- CONTENT AREA -->

    </div>
@endsection

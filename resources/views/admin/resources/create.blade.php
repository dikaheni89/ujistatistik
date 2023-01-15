@extends('admin.theme.index')
@section('title', $title)
@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <form class="form-vertical" action="{{ route('admin.resources.store', $dataset->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <span class="text-danger">
                                * Yang bertanda bintang wajib diisi
                            </span>
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label">File<label class="text-danger">*</label> :</label>
                            <input type="file" name="file" class="form-control @error('file') is-invalid @enderror"
                                value="{{ old('file') }}" required>
                            @error('file')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label">Nama File<label class="text-danger">*</label> :</label>
                            <input type="text" name="name" class="form-control" placeholder="Data Pegawai" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label">Deskripsi :</label>
                            <textarea class="form-control" name="description" placeholder="Masukkan Deskripsi Singkat"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary font-weight-bold">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

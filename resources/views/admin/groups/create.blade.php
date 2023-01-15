@extends('admin.theme.index')
@section('title', $title)
@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <form class="form-vertical" action="{{ route('admin.groups.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <span class="text-danger">
                                * Yang bertanda bintang wajib diisi
                            </span>
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label">Nama Group<label class="text-danger">*</label> :</label>
                            <input type="text" name="group_name" class="form-control"
                                placeholder="Badan Pelayanan Pajak Daerah" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label">Deskripsi :</label>
                            <textarea class="form-control" name="description" placeholder="Masukkan Deskripsi Singkat grup"></textarea>
                        </div>
                        <div class="form-group mb-4">
                            <label class="control-label">Url Gambar Group :</label>
                            <input type="text" name="image" class="form-control"
                                placeholder="http://example.com/my-image.jpg">
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
